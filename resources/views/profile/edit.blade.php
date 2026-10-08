<x-layouts.app :title="'Profile'">
    <section class="mx-auto max-w-5xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="mb-8"><p class="text-sm font-semibold uppercase tracking-wide text-[#A77B4F]">Account</p><h1 class="mt-2 text-3xl font-bold tracking-tight text-[#30271F]">Profile Settings</h1></div>

        <div class="grid gap-6 lg:grid-cols-[1fr_.8fr]">
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="card p-6">@csrf @method('PUT')
                <div class="mb-5 flex items-center gap-4"><img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="h-16 w-16 rounded-full object-cover"><div><h2 class="text-xl font-semibold">Public profile</h2><p class="text-sm text-slate-500">Shown beside posts and comments.</p></div></div>
                <div class="grid gap-4 sm:grid-cols-2"><div><label class="label">Name</label><input name="name" value="{{ old('name', $user->name) }}" class="input" required></div><div><label class="label">Email</label><input name="email" type="email" value="{{ old('email', $user->email) }}" class="input" required></div></div>
                <div class="mt-4"><label class="label">Bio</label><textarea name="bio" rows="5" class="input">{{ old('bio', $user->bio) }}</textarea></div>
                <div class="mt-4"><label class="label">Avatar</label><input name="avatar" type="file" accept="image/*" class="input"></div>
                <button class="btn-primary mt-5">Save Profile</button>
            </form>
            <form method="POST" action="{{ route('profile.password') }}" class="card p-6">@csrf @method('PUT')
                <h2 class="text-xl font-semibold">Change password</h2>
                <div class="mt-5 grid gap-4"><div><label class="label">Current Password</label><input name="current_password" type="password" class="input" required></div><div><label class="label">New Password</label><input name="password" type="password" class="input" required></div><div><label class="label">Confirm Password</label><input name="password_confirmation" type="password" class="input" required></div></div>
                <button class="btn-primary mt-5">Update Password</button>
            </form>
        </div>
    </section>
</x-layouts.app>
