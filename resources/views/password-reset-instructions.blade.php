<!DOCTYPE html>
<html>
<head>
    <title>Reset Password - MelonBucks</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            text-align: center;
        }
        .logo {
            color: #00704A;
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 30px;
        }
        .btn {
            background-color: #00704A;
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 8px;
            display: inline-block;
            margin: 20px 0;
        }
        .instructions {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="logo">MelonBucks</div>
    
    <h2>Reset Your Password</h2>
    
    <p>Click the button below to open the MelonBucks app and reset your password:</p>
    
    <a href="{{ $deepLink }}" class="btn">Open MelonBucks App</a>
    
    <div class="instructions">
        <h3>Don't have the app?</h3>
        <p>Download MelonBucks from:</p>
        <a href="https://play.google.com/store" target="_blank">Google Play Store</a> | 
        <a href="https://apps.apple.com" target="_blank">App Store</a>
    </div>
    
    <div class="instructions">
        <h3>App not opening?</h3>
        <p>Copy this link and paste it in your mobile browser:</p>
        <code style="word-break: break-all;">{{ $deepLink }}</code>
    </div>
    
    <script>
        // Auto-redirect after 3 seconds on mobile
        if (/Mobile|Android|iPhone|iPad/.test(navigator.userAgent)) {
            setTimeout(function() {
                window.location.href = '{{ $deepLink }}';
            }, 3000);
        }
    </script>
</body>
</html>