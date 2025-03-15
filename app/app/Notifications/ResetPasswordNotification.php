<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
	protected string $token;

	public function __construct(string $token)
	{
		$this->token = $token;
	}

	public function via($notifiable): array
	{
		return ['mail'];
	}

	public function toMail($notifiable): MailMessage
	{
		return (new MailMessage)
			->subject(__('reset_password.singular'))
			->line(__('reset_password.description'))
			->action(__('reset_password.actions.new_password'), route('reset-password.index', ['token' => $this->token]))
			->line(__('reset_password.sentences.expire'));
	}
}
