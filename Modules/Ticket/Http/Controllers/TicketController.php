<?php

namespace Modules\Ticket\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Modules\Common\Responses\AjaxResponses;
use Modules\RolePermissions\Models\Permission;
use Modules\Ticket\Http\Requests\ReplyRequest;
use Modules\Ticket\Http\Requests\TicketRequest;
use Modules\Ticket\Models\Reply;
use Modules\Ticket\Models\Ticket;
use Modules\Ticket\Repositories\TicketRepo;
use Modules\Ticket\Services\ReplyService;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * @param TicketRepo $repo
     * @param Request    $request
     *
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function index(TicketRepo $repo, Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        if (auth()->user()->can(Permission::PERMISSION_MANAGE_TICKETS)) {
            $tickets = $repo->joinUsers()
                            ->searchEmail($request->email)
                            ->searchName($request->name)
                            ->searchTitle($request->title)
                            ->searchDate(dateFromJalali($request->date))
                            ->searchStatus($request->status)
                            ->paginate();
        } else {
            $tickets = $repo->paginateAll(auth()->id());
        }
        return view("Tickets::index", compact("tickets"));
    }

    /**
     * @param            $ticket
     * @param TicketRepo $repo
     *
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     * @throws AuthorizationException
     */
    public function show($ticket, TicketRepo $repo): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $ticket = $repo->findOrFailWithReplies($ticket);
        $this->authorize("show", $ticket);
        return view("Tickets::show", compact("ticket"));
    }

    /**
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view("Tickets::create");
    }

    /**
     * @param TicketRequest $request
     * @param TicketRepo    $repo
     *
     * @return RedirectResponse
     */
    public function store(TicketRequest $request, TicketRepo $repo): RedirectResponse
    {
        $ticket = $repo->store($request->title);
        ReplyService::store($ticket, $request->body, $request->attachment);
        newFeedback();
        return redirect()->route("tickets.index");
    }

    /**
     * @param Ticket       $ticket
     * @param ReplyRequest $request
     *
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function reply(Ticket $ticket, ReplyRequest $request): RedirectResponse
    {
        $this->authorize("show", $ticket);
        ReplyService::store($ticket, $request->body, $request->attachment);
        newFeedback();
        return redirect()->route("tickets.show", $ticket->id);
    }

    /**
     * @param Ticket     $ticket
     * @param TicketRepo $repo
     *
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function close(Ticket $ticket, TicketRepo $repo): RedirectResponse
    {
        $this->authorize("show", $ticket);
        $repo->setStatus($ticket->id, Ticket::STATUS_CLOSE);
        newFeedback();
        return redirect()->route("tickets.index");
    }

    /**
     * @param Ticket $ticket
     *
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(Ticket $ticket): JsonResponse
    {
        $this->authorize("delete", $ticket);
        $hasAttachments = Reply::query()->where("ticket_id", $ticket->id)->whereNotNull("media_id")->with("media")->get();
        foreach ($hasAttachments as $reply) {
            $reply->media->delete();
        }
        $ticket->delete();
        return AjaxResponses::SuccessResponse();
    }
}
