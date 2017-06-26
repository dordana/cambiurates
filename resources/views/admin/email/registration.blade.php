<p>Welcome to Cambiu!</p>

<p>The world’s first currency marketplace.</p>

<p>Your initial Password for the account under {{ $user->email }} is:</p>
<p>{{ $password }}</p>

<p>Click <a href="{{ $link = url('admin/password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> here </a> to change the password</p>

<p>Or</p>

<p>Click <a href="{{ url('admin/login') }}">here</a> to login to the system.</p>

<p>If you need help or assistance please shoot us an email at Info@cambiu.com or give us a Call:  +972542475347</p>

<p>Cambiu team</p>
