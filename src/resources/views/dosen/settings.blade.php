@extends('dosen.layout')

@section('page-title', 'Settings')

@section('content')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Settings Menu -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Settings Menu</h2>
                <nav class="space-y-2">
                    <a href="#profile" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">Profile Information</a>
                    <a href="#password" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">Change Password</a>
                    <a href="#notifications" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">Notifications</a>
                    <a href="#preferences" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">Application Preferences</a>
                </nav>
            </div>
        </div>

        <!-- Settings Content -->
        <div class="lg:col-span-2">
            <!-- Profile Information -->
            <div id="profile" class="bg-white rounded-lg shadow p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Profile Information</h3>
                <form method="POST" action="{{ route('dosen.settings.update') }}">
                    @csrf
                    @method('PATCH')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                            <input type="text" name="name" value="{{ Auth::user()->name }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" value="{{ Auth::user()->email }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                            <input type="tel" name="phone" value="{{ Auth::user()->phone ?? '' }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                            <input type="text" name="department" value="{{ Auth::user()->department ?? '' }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Update Profile</button>
                    </div>
                </form>
            </div>

            <!-- Change Password -->
            <div id="password" class="bg-white rounded-lg shadow p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Change Password</h3>
                <form method="POST" action="{{ route('dosen.settings.password') }}">
                    @csrf
                    @method('PATCH')
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                            <input type="password" name="current_password" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                            <input type="password" name="password" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                            <input type="password" name="password_confirmation" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Change Password</button>
                    </div>
                </form>
            </div>

            <!-- Notifications -->
            <div id="notifications" class="bg-white rounded-lg shadow p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Notification Preferences</h3>
                <form method="POST" action="{{ route('dosen.settings.notifications') }}">
                    @csrf
                    @method('PATCH')
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" name="email_notifications" id="email_notifications" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="email_notifications" class="ml-2 block text-sm text-gray-900">Email notifications for new applications</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="approval_reminders" id="approval_reminders" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="approval_reminders" class="ml-2 block text-sm text-gray-900">Reminders for pending approvals</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="system_updates" id="system_updates" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="system_updates" class="ml-2 block text-sm text-gray-900">System updates and announcements</label>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Save Preferences</button>
                    </div>
                </form>
            </div>

            <!-- Application Preferences -->
            <div id="preferences" class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Application Preferences</h3>
                <form method="POST" action="{{ route('dosen.settings.preferences') }}">
                    @csrf
                    @method('PATCH')
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Preferred Business Fields</label>
                            <select name="preferred_fields[]" multiple class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @foreach($businessFields ?? [] as $field)
                                <option value="{{ $field->id }}">{{ $field->name }}</option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-1">Hold Ctrl/Cmd to select multiple fields</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Auto-approval threshold</label>
                            <select name="auto_approval_threshold" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="none">No auto-approval</option>
                                <option value="low">Low priority applications</option>
                                <option value="medium">Medium and low priority</option>
                            </select>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="show_rejected" id="show_rejected" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="show_rejected" class="ml-2 block text-sm text-gray-900">Show rejected applications in my view</label>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Save Preferences</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection