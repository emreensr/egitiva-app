@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
@else
<img src="https://education-system-nuxt3.pages.dev/headLogo.png" class="logo" alt="Eğitiva Logo" width="300" height="100">
@endif
</a>
</td>
</tr>
