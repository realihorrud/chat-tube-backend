<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Optional;

final class Update extends Dto
{
    public function __construct(
        public int $update_id,
        public Optional|Message $message,
        public Optional|Message $edited_message,
        public Optional|Message $channel_post,
        public Optional|BusinessConnection $business_connection,
        public Optional|Message $business_message,
        public Optional|Message $edited_business_message,
        public Optional|BusinessMessageDeleted $deleted_business_messages,
        public Optional|MessageReactionUpdated $message_reaction,
        public Optional|MessageReactionCountUpdated $message_reaction_count,
        public Optional|InlineQuery $inline_query,
        public Optional|ChosenInlineResult $chosen_inline_result,
        public Optional|CallbackQuery $callback_query,
        public Optional|ShippingQuery $shipping_query,
        public Optional|PreCheckoutQuery $pre_checkout_query,
        public Optional|PurchasedPaidMedia $purchased_paid_media,
        public Optional|Poll $poll,
        public Optional|PollAnswer $poll_answer,
        public Optional|ChatMemberUpdated $my_chat_member,
        public Optional|ChatMemberUpdated $chat_member,
        public Optional|ChatJoinRequest $chat_join_request,
        public Optional|ChatBoostUpdated $chat_boost,
        public Optional|ChatBoostRemoved $removed_chat_boost,
    ) {}
}
