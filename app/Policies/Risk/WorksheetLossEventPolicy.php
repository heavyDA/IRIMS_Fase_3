<?php

namespace App\Policies\Risk;

use App\Models\Risk\WorksheetLossEvent;
use App\Models\User;
use App\Services\RoleService;
use Illuminate\Auth\Access\Response;

class WorksheetLossEventPolicy
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
    public function view(User $user, WorksheetLossEvent $worksheetLossEvent): Response
    {
        return $this->checkIfRiskAdmin($user, $worksheetLossEvent);
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
    public function update(User $user, WorksheetLossEvent $worksheetLossEvent): Response
    {
        return $this->checkIfRiskAdmin($user, $worksheetLossEvent);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, WorksheetLossEvent $worksheetLossEvent): Response
    {
        return $this->checkIfRiskAdmin($user, $worksheetLossEvent);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, WorksheetLossEvent $worksheetLossEvent): Response
    {
        return $this->checkIfRiskAdmin($user, $worksheetLossEvent);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, WorksheetLossEvent $worksheetLossEvent): Response
    {
        return $this->checkIfRiskAdmin($user, $worksheetLossEvent);
    }

    private function checkIfRiskAdmin(User $user, WorksheetLossEvent $worksheetLossEvent)
    {
        return ($this->roleService->isRiskAdmin() && $worksheetLossEvent->created_by == $user->employee_id) ||
            !$this->roleService->isRiskAdmin() ? Response::allow() : Response::denyAsNotFound(code: 404);
    }
}
