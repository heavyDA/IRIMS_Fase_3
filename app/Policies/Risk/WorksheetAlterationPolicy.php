<?php

namespace App\Policies\Risk;

use App\Models\Risk\WorksheetAlteration;
use App\Models\User;
use App\Models\UserUnit;
use App\Services\RoleService;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class WorksheetAlterationPolicy
{
    public function __construct(
        private RoleService $roleService
    ) {}

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User|UserUnit $user): Response
    {
        return $this->roleService->checkPermission('risk.report.alterations.index') ?
            Response::allow() : Response::denyAsNotFound(code: HttpFoundationResponse::HTTP_NOT_FOUND);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User|UserUnit $user, WorksheetAlteration $worksheetAlteration): Response
    {
        return $this->roleService->checkPermission('risk.report.alterations.index') ?
            Response::allow() : Response::denyAsNotFound(code: HttpFoundationResponse::HTTP_NOT_FOUND);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User|UserUnit $user): Response|bool
    {
        return
            $this->roleService->checkPermission('risk.report.alterations.create') ?
            Response::allow() : Response::denyAsNotFound(code: HttpFoundationResponse::HTTP_NOT_FOUND);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User|UserUnit $user, WorksheetAlteration $worksheetAlteration): Response
    {
        return $this->roleService->checkPermission('risk.report.alterations.update') &&
            $this->isRiskAdmin($user, $worksheetAlteration) ?
            Response::allow() : Response::denyAsNotFound(code: HttpFoundationResponse::HTTP_NOT_FOUND);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User|UserUnit $user, WorksheetAlteration $worksheetAlteration): Response
    {
        return $this->roleService->checkPermission('risk.report.alterations.destroy') &&
            $this->isRiskAdmin($user, $worksheetAlteration) ? Response::allow() : Response::denyAsNotFound(code: HttpFoundationResponse::HTTP_NOT_FOUND);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User|UserUnit $user, WorksheetAlteration $worksheetAlteration): Response
    {
        return $this->roleService->checkPermission('risk.report.alterations.destroy') &&
            $this->isRiskAdmin($user, $worksheetAlteration) ? Response::allow() : Response::denyAsNotFound(code: HttpFoundationResponse::HTTP_NOT_FOUND);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User|UserUnit $user, WorksheetAlteration $worksheetAlteration): Response
    {
        return $this->roleService->checkPermission('risk.report.alterations.destroy') &&
            $this->isRiskAdmin($user, $worksheetAlteration) ? Response::allow() : Response::denyAsNotFound(code: HttpFoundationResponse::HTTP_NOT_FOUND);
    }

    private function isRiskAdmin(User|UserUnit $user, WorksheetAlteration $worksheetAlteration)
    {
        return ($this->roleService->isRiskAdmin() && $worksheetAlteration->created_by == $user->employee_id) ||
            !($this->roleService->isRiskAdmin() || $this->roleService->isRiskReviewer());
    }
}
