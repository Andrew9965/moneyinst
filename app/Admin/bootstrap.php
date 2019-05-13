<?php
use Encore\Admin\Form;
use App\Admin\Extensions\Form\CKEditor;
use Encore\Admin\Facades\Admin;

Admin::js(asset('js/balance.js'));
Encore\Admin\Form::forget(['map', 'editor']);
Form::extend('ckeditor', CKEditor::class);


Admin::navbar(function (\Encore\Admin\Widgets\Navbar $navbar) {
    $navbar->right(new \App\Admin\Extensions\Nav\Links());
});