<div style="text-align: center">
<h1 style="text-align: center">Payments Express</h1>
<div style="background-color: cornflowerblue; color: white;padding-top: 20px;padding:bottom: 20px;text-align: center">
<h3 style="text-align: center">Welcome to Payments Express</h3>
<p style="text-align: center">Your account has been created with payments express. You can login via following credentials:</p>
<p style="text-align: center">Username: {{$email}}</p>
<p style="text-align: center">Password: {{$password}}</p>
<p>
@component('mail::button', ['url' => route('login'), 'color' => 'primary'])
Login
@endcomponent
</p>
</div>
<p style="text-align: center">if you have any queries, you can just hit reply to contact our support team.<br>Regards,<br>Payments Express</p>
</div>