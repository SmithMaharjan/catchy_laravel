    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <!-- Email -->
        <div>
            <label for="email">Email</label>
            <input id="email" type="email" name="email" required autofocus value="{{ old('email') }}">
        </div>

        <!-- New Password -->
        <div>
            <label for="password">New Password</label>
            <input id="password" type="password" name="password" required>
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required>
        </div>

        <button type="submit">
            Reset Password
        </button>
    </form>