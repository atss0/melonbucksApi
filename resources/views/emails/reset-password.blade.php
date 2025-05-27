<p>Hello!</p>

<p>You are receiving this email because we received a password reset request for your account.</p>

<p>
    <a href="{{ route('password.reset', ['token' => $token, 'email' => $email]) }}" 
       style="background-color: #00704A; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
        Reset Password
    </a>
</p>

<p>If you're on mobile, this link will open the MelonBucks app directly.</p>

<p>This password reset link will expire in 60 minutes.</p>

<p>If you did not request a password reset, no further action is required.</p>

<p>Regards,<br>MelonBucks Team</p>