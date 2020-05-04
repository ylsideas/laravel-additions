<?php


namespace YlsIdeas\LaravelAdditions\Support;


use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Mail\Markdown;
use Illuminate\Notifications\Messages\MailMessage;
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
                        ViewFactory::class
                    )
                        ->make($args[0]->view, $args[0]->viewData)
                        ->render()
                )
            );
        } elseif (($args[0] ?? false) && $args[0] instanceof Notification) {
            list($notification, $channel, $notifiable, $locale) = $args;

            $rendered = null;

            $mail =
                method_exists($notification, 'toMail') ?
                    $notification->toMail($notifiable) :
                    null;
            if ($mail instanceof Mailable) {
                $rendered = new ViewAssertion(
                    resolve(
                        ViewFactory::class
                    )
                        ->make($mail->view, $mail->viewData)
                        ->render()
                );
            } elseif ($mail instanceof MailMessage) {
                if ($mail->view) {
                    $rendered = new ViewAssertion(
                        resolve(
                            ViewFactory::class
                        )
                            ->make($mail->view, $mail->viewData)
                            ->render()
                    );
                } else {
                    $rendered = new ViewAssertion(
                        (string) resolve(Markdown::class)
                            ->render($mail->markdown, $mail->data())
                    );
                }
            } else {
                return false;
            }

            return call_user_func(
                $this->callable,
                $rendered,
                $channel,
                $notifiable,
                $locale
            );
        }

        return false;
    }
}
