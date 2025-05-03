<?php

namespace App\Policies\Risk;

use App\Models\Risk\WorksheetLossEvent;
use App\Models\User;
use App\Services\RoleService;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class WorksheetLossEventPolicy
{
    use HandlesAuthorization;

    public function __construct(
        private RoleService $roleService
    ) {}

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return $this->roleService->authorizeCurrentRole('risk.report.loss_events.index') ?
            Response::allow() : Response::denyAsNotFound(code: HttpFoundationResponse::HTTP_NOT_FOUND);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, WorksheetLossEvent $worksheetLossEvent): Response
    {
        return $this->roleService->authorizeCurrentRole('risk.report.loss_events.index') ?
            Response::allow() : Response::denyAsNotFound(code: HttpFoundationResponse::HTTP_NOT_FOUND);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response|bool
    {
        return $this->roleService->authorizeCurrentRole('risk.report.loss_events.create') ?
            Response::allow() : Response::denyAsNotFound(code: HttpFoundationResponse::HTTP_NOT_FOUND);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, WorksheetLossEvent $worksheetLossEvent): Response
    {
        $allow = $this->roleService->authorizeCurrentRole('risk.report.loss_events.update');
        $allow = $this->isRiskAdmin($user, $worksheetLossEvent) ? false : $allow;

        return $allow ?
            Response::allow() : Response::denyAsNotFound(code: HttpFoundationResponse::HTTP_NOT_FOUND);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, WorksheetLossEvent $worksheetLossEvent): Response
    {
        $allow = $this->roleService->authorizeCurrentRole('risk.report.loss_events.destroy');
        $allow = $this->isRiskAdmin($user, $worksheetLossEvent) ? false : $allow;

        return $allow ? Response::allow() : Response::denyAsNotFound(code: HttpFoundationResponse::HTTP_NOT_FOUND);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, WorksheetLossEvent $worksheetLossEvent): Response
    {
        $allow = $this->roleService->authorizeCurrentRole('risk.report.loss_events.destroy');
        $allow = $this->isRiskAdmin($user, $worksheetLossEvent) ? false : $allow;

        return $allow ? Response::allow() : Response::denyAsNotFound(code: HttpFoundationResponse::HTTP_NOT_FOUND);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, WorksheetLossEvent $worksheetLossEvent): Response
    {
        $allow = $this->roleService->authorizeCurrentRole('risk.report.loss_events.destroy');
        $allow = $this->isRiskAdmin($user, $worksheetLossEvent) ? false : $allow;

        return $allow ? Response::allow() : Response::denyAsNotFound(code: HttpFoundationResponse::HTTP_NOT_FOUND);
    }

    private function isRiskAdmin(User $user, WorksheetLossEvent $worksheetLossEvent)
    {
        return $this->roleService->isRiskAdmin() && $worksheetLossEvent->created_by != $user->employee_id;
    }
}
