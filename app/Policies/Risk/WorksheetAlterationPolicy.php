<?php

namespace App\Policies\Risk;

use App\Models\Risk\WorksheetAlteration;
use App\Models\User;
use App\Services\RoleService;
use Illuminate\Auth\Access\Response;

class WorksheetAlterationPolicy
{
    public function __construct(
        private RoleService $roleService
    ) {}
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, WorksheetAlteration $worksheetAlteration): Response
    {
        return $this->checkIfRiskAdmin($user, $worksheetAlteration);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $this->roleService->isRiskOtorisator() || $this->roleService->isRiskReviewer() ? Response::denyAsNotFound(code: 404) : Response::allow();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, WorksheetAlteration $worksheetAlteration): Response
    {
        return $this->checkIfRiskAdmin($user, $worksheetAlteration);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, WorksheetAlteration $worksheetAlteration): Response
    {
        return $this->checkIfRiskAdmin($user, $worksheetAlteration);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, WorksheetAlteration $worksheetAlteration): Response
    {
        return $this->checkIfRiskAdmin($user, $worksheetAlteration);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, WorksheetAlteration $worksheetAlteration): Response
    {
        return $this->checkIfRiskAdmin($user, $worksheetAlteration);
    }

    private function checkIfRiskAdmin(User $user, WorksheetAlteration $worksheetAlteration)
    {
        return ($this->roleService->isRiskAdmin() && $worksheetAlteration->created_by == $user->employee_id) ||
            !$this->roleService->isRiskAdmin() ? Response::allow() : Response::denyAsNotFound(code: 404);
    }
}
