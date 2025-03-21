@props(['type'=>'dark' ,'link'=>false])
@if ($link)
<a href='{{ config(' app.url') }}'>
    @endif
    <img src="{{ image_url(setting('site.logo'), admin_asset('images/logo.png')) }}" style="width:160px">
    {{ $link?'</a>':''}}
