<?php


namespace YlsIdeas\LaravelAdditions\Support;


use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Mail\Markdown;
use Illuminate\Notifications\Notification;
use NunoMaduro\LaravelMojito\ViewAssertion;

class MailViewAssertion
{
    /**
     * @var callable
     */
    protected $callable;

    public static function make(callable $callable)
    {
        return new MailViewAssertion($callable);
    }

    protected function __construct(callable $callable)
    {
        $this->callable = $callable;
    }

    public function __invoke()
    {
        $args = func_get_args();

        if (($args[0] ?? false) && $args[0] instanceof Mailable) {
            return call_user_func(
                $this->callable,
                new ViewAssertion(
                    resolve(
                        \Illuminate\Contracts\View\Factory::class
                    )
                        ->make($args[0]->view, $args[0]->viewData)
                        ->render()
                )
            );
        } elseif (($args[0] ?? false) && $args[0] instanceof Notification) {
            list($notification, $channel, $notifiable, $locale) = $args;

            return call_user_func(
                $this->callable,
                $mailMessage = method_exists($notification, 'toMail') &&
                ($mailMessage = $notification->toMail($notifiable)) &&
                (!$mailMessage instanceof Mailable) ?
                    new ViewAssertion(
                        resolve(Markdown::class)->render('notifications::email', $mailMessage->data())
                    ) :
                    null,
                $channel,
                $notifiable,
                $locale
            );
        }

        return false;
    }
}
