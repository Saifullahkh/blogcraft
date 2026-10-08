<x-layouts.admin :title="'Settings'">
    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="mx-auto max-w-4xl card p-6">@csrf @method('PUT')
        <div class="grid gap-4 sm:grid-cols-2"><div><label class="label">Website Name</label><input name="website_name" value="{{ old('website_name', $siteSettings['website_name'] ?? $siteName) }}" class="input" required></div><div><label class="label">Contact Email</label><input name="contact_email" type="email" value="{{ old('contact_email', $siteSettings['contact_email'] ?? '') }}" class="input"></div></div>
        <div class="mt-4"><label class="label">Website Description</label><input name="website_description" value="{{ old('website_description', $siteSettings['website_description'] ?? '') }}" class="input"></div>
        <div class="mt-4"><label class="label">Footer Text</label><input name="footer_text" value="{{ old('footer_text', $siteSettings['footer_text'] ?? '') }}" class="input"></div>
        <div class="mt-4 grid gap-4 sm:grid-cols-2"><div><label class="label">Logo</label><input name="logo" type="file" class="input"></div><div><label class="label">Favicon</label><input name="favicon" type="file" class="input"></div></div>
        <h2 class="mt-8 text-lg font-semibold">Social Links</h2>
        <div class="mt-4 grid gap-4 sm:grid-cols-2">@foreach(['facebook_url' => 'Facebook', 'instagram_url' => 'Instagram', 'linkedin_url' => 'LinkedIn', 'twitter_url' => 'X/Twitter', 'youtube_url' => 'YouTube'] as $key => $label)<div><label class="label">{{ $label }}</label><input name="{{ $key }}" value="{{ old($key, $siteSettings[$key] ?? '') }}" class="input"></div>@endforeach</div>
        <button class="btn-primary mt-6">Save Settings</button>
    </form>
</x-layouts.admin>
