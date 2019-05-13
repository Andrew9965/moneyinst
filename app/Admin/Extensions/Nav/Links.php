<?php

namespace App\Admin\Extensions\Nav;

class Links
{
    public function __toString()
    {

        $host = request()->server('HTTP_HOST');
        $prot = request()->server("REQUEST_SCHEME");

        $sites = \App\Models\Sites::where('status','0')->get();
        $messages = \App\Models\Messages::where('recipient_id','0')->where('read_at', null)->get();

        $new = count($sites) ? "<li><a href=\"/admin/sites?status=0\">Новые сайты <i class=\"fa fa-globe\"></i><span class=\"label label-warning\">".count($sites)."</span></a></li>" : "";
        $new .= count($messages) ? "<li><a href=\"/admin/messages?type=no_read\">Неотвеченные сообщения <i class=\"fa fa-envelope\"></i><span class=\"label label-warning\">".count($messages)."</span></a></li>" : "";
        /*$new .= count($feedback) ? "<li><a href=\"/admin/feedback\"><i class=\"fa fa-feed\"></i><span class=\"label label-warning\">".count($feedback)."</span></a></li>" : "";
        $new .= count($reviews) ? "<li><a href=\"/admin/reviews\"><i class=\"fa fa-wechat\"></i><span class=\"label label-warning\">".count($reviews)."</span></a></li>" : "";*/

        return <<<HTML

{$new}
        
<li>
    <a href="{$prot}://{$host}/" target="_blank">
        <span class="label label-success"></span>
        Web site <i class="fa fa-external-link" aria-hidden="true"></i>
    </a>
</li>

HTML;
    }
}