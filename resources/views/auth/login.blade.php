<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | Caffeshop Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

    <style>
        :root {
            --primary: #007bff;
            --primary-dark: #0056b3;
            --bg: #ffffff;
            --text: #0f172a;
            --muted: #64748b;
        }

        * {
            box-sizing: border-box;
            font-family: 'Inter', system-ui, sans-serif;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background:
                radial-gradient(circle at top, rgba(255,255,255,.15), transparent 40%),
                linear-gradient(135deg, #007bff, #002f6c);
        }

        /* CONTAINER */
        .login-wrapper {
            width: 100%;
            max-width: 420px;
        }

        /* HEADER */
        .login-header {
            text-align: center;
            color: #fff;
            margin-bottom: 2rem;
        }

        .logo {
            width: 70px;
            height: 70px;
            background: rgba(255,255,255,.18);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            font-size: 28px;
        }

        .login-header h1 {
            margin: 0;
            font-size: 1.9rem;
            font-weight: 800;
            letter-spacing: .04em;
        }

        /* CARD */
        .login-card {
            background: var(--bg);
            border-radius: 24px;
            padding: 2.6rem 2.4rem;
            box-shadow:
                0 40px 80px rgba(0,0,0,.35),
                inset 0 0 0 1px rgba(255,255,255,.08);
            animation: pop .6s ease;
        }

        .login-card p {
            text-align: center;
            color: var(--muted);
            margin-bottom: 2rem;
            font-size: .95rem;
        }

        /* FORM */
        .form-group {
            margin-bottom: 1.4rem;
        }

        .form-group label {
            display: block;
            font-size: .85rem;
            margin-bottom: .4rem;
            color: var(--text);
            font-weight: 600;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i.icon-left {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: .9rem;
        }

        .input-wrapper i.toggle-password {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            cursor: pointer;
            font-size: .95rem;
        }

        .input-wrapper input {
            width: 100%;
            height: 52px;
            padding: 0 42px 0 40px;
            border-radius: 16px;
            border: 1px solid #cbd5f5;
            font-size: .95rem;
        }

        .input-wrapper input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(0,123,255,.25);
        }

        /* BUTTON */
        .btn-login {
            width: 100%;
            height: 52px;
            border-radius: 16px;
            border: none;
            cursor: pointer;
            font-weight: 700;
            letter-spacing: .04em;
            color: #fff;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            transition: all .25s ease;
            margin-top: .6rem;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 30px rgba(0,123,255,.45);
        }

        /* FOOTER */
        .login-footer {
            margin-top: 1.8rem;
            text-align: center;
            font-size: .8rem;
            color: #94a3b8;
            line-height: 1.5;
        }

        /* ERROR */
        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: .8rem 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-size: .85rem;
        }

        @keyframes pop {
            from {
                opacity: 0;
                transform: translateY(25px) scale(.96);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
    </style>
</head>

<body>

<div class="login-wrapper">

    <!-- HEADER -->
    <div class="login-header">
        <div class="logo">
            <i class="fas fa-coffee"></i>
        </div>
        <h1>Caffeshop Admin</h1>
    </div>

    <!-- CARD -->
    <div class="login-card">

        <p>Silakan login untuk masuk ke dashboard</p>

        @if($errors->any())
            <div class="error">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.login.process') }}" method="POST">
            @csrf

            <!-- EMAIL -->
            <div class="form-group">
                <label>Email</label>
                <div class="input-wrapper">
                    <i class="fas fa-envelope icon-left"></i>
                    <input type="email"
                           name="email"
                           value="{{ old('email') }}"
                           placeholder="admin@caffeshop.test"
                           required>
                </div>
            </div>

            <!-- PASSWORD -->
            <div class="form-group">
                <label>Password</label>
                <div class="input-wrapper">
                    <i class="fas fa-lock icon-left"></i>
                    <input type="password"
                           name="password"
                           id="password"
                           placeholder="••••••••"
                           required>
                    <i class="fas fa-eye toggle-password" id="togglePassword"></i>
                </div>
            </div>

            <button type="submit" class="btn-login">
                LOGIN
            </button>
        </form>

        <div class="login-footer">
            Email: <code>admin@caffeshop.test</code><br>
            Pass: <code>password123</code>
        </div>

    </div>
</div>

<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    togglePassword.addEventListener('click', function () {
        const type = passwordInput.getAttribute('type') === 'password'
            ? 'text'
            : 'password';

        passwordInput.setAttribute('type', type);

        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });
</script>

</body>
</html>
