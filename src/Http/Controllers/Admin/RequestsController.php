<?php

declare(strict_types=1);

namespace Moanasoft\SupportFlowCore\Http\Controllers\Admin;

use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;
use Moanasoft\SupportFlowCore\Models\SupportFlowRequest;
use Moanasoft\SupportFlowCore\SupportFlowAdminView;

final class RequestsController extends Controller
{
    public function index(SupportFlowAdminView $view): View
    {
        return view($view->resolve('requests.index'), [
            'requests' => SupportFlowRequest::query()->latest()->paginate(25),
        ]);
    }

    public function show(SupportFlowAdminView $view, int $id): View
    {
        return view($view->resolve('requests.show'), [
            'request' => SupportFlowRequest::query()->findOrFail($id),
        ]);
    }
}
