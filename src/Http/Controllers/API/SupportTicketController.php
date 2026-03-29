<?php

namespace Juzaweb\Modules\SupportTicket\Http\Controllers\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Juzaweb\Modules\Core\Http\Controllers\APIController;
use Juzaweb\Modules\SupportTicket\Http\Requests\API\StoreSupportTicketRequest;
use Juzaweb\Modules\SupportTicket\Http\Requests\API\StoreSupportTicketReplyRequest;
use Juzaweb\Modules\SupportTicket\Http\Resources\API\SupportTicketResource;
use Juzaweb\Modules\SupportTicket\Http\Resources\API\SupportTicketReplyResource;
use Juzaweb\Modules\SupportTicket\Models\SupportTicket;
use Juzaweb\Modules\SupportTicket\Models\SupportTicketReply;
use OpenApi\Annotations as OA;

class SupportTicketController extends APIController
{
    /**
     * @OA\Get(
     *      path="/api/v1/support-tickets",
     *      tags={"Support Ticket"},
     *      summary="Get user support tickets",
     *      description="Returns the authenticated user's support tickets.",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(ref="#/components/parameters/query_limit"),
     *      @OA\Parameter(ref="#/components/parameters/query_page"),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/SupportTicketResource"))
     *          )
     *      ),
     *      @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        $tickets = SupportTicket::ofUser($user)->paginate($this->getLimitRequest());

        return response()->json(
            SupportTicketResource::collection($tickets)->response()->getData(true)
        );
    }

    /**
     * @OA\Post(
     *      path="/api/v1/support-tickets",
     *      tags={"Support Ticket"},
     *      summary="Create support ticket",
     *      description="Create a new support ticket.",
     *      security={{"bearerAuth":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"subject","content"},
     *              @OA\Property(property="subject", type="string"),
     *              @OA\Property(property="content", type="string"),
     *              @OA\Property(property="category_id", type="integer", nullable=true)
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="data", ref="#/components/schemas/SupportTicketResource")
     *          )
     *      ),
     *      @OA\Response(response=401, description="Unauthorized"),
     *      @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(StoreSupportTicketRequest $request): JsonResponse
    {
        $user = $request->user();

        $ticket = SupportTicket::create([
            'subject' => $request->input('subject'),
            'content' => $request->input('content'),
            'category_id' => $request->input('category_id'),
            'ticketable_type' => get_class($user),
            'ticketable_id' => $user->getKey(),
            'status' => 'open',
        ]);

        return response()->json(
            ['data' => new SupportTicketResource($ticket)],
            201
        );
    }

    /**
     * @OA\Post(
     *      path="/api/v1/support-tickets/{id}/reply",
     *      tags={"Support Ticket"},
     *      summary="Reply support ticket",
     *      description="Reply to a support ticket.",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"content"},
     *              @OA\Property(property="content", type="string")
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="data", ref="#/components/schemas/SupportTicketReplyResource")
     *          )
     *      ),
     *      @OA\Response(response=401, description="Unauthorized"),
     *      @OA\Response(response=404, description="Not found"),
     *      @OA\Response(response=422, description="Validation error")
     * )
     */
    public function reply(StoreSupportTicketReplyRequest $request, string $id): JsonResponse
    {
        $user = $request->user();

        $ticket = SupportTicket::ofUser($user)->findOrFail($id);

        $reply = SupportTicketReply::create([
            'ticket_id' => $ticket->id,
            'user_id' => $user->getKey(),
            'content' => $request->input('content'),
            'is_staff_reply' => false,
        ]);

        $ticket->update(['status' => 'open']);

        return response()->json(
            ['data' => new SupportTicketReplyResource($reply)],
            201
        );
    }
}
