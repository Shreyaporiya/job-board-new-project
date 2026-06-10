<x-app-layout>
    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg mt-5">

        <div class="max-w-xl">

            <h2 class="text-lg font-medium text-gray-900 mb-4">
                Subscription Details
            </h2>


            @php
                echo auth()->user()->subscribed('default'); // true or false
            @endphp

            @if(auth()->user()->subscribed('default'))

                    @php

                        $subscription =
                            auth()->user()->subscription('default');

                    @endphp

                    <div class="mb-4 p-4 bg-green-100 rounded">

                        <p class="text-green-700 font-bold">
                            Active Subscription
                        </p>

                    </div>

                    <table class="table-auto w-full border">

                        <tr class="border">
                            <td class="p-2 font-bold">
                                Subscription ID
                            </td>

                            <td class="p-2">
                                {{ $subscription->stripe_id }}
                            </td>
                        </tr>

                        <tr class="border">
                            <td class="p-2 font-bold">
                                Status
                            </td>

                            <td class="p-2">
                                {{ $subscription->stripe_status }}
                            </td>
                        </tr>

                        <tr class="border">
                            <td class="p-2 font-bold">
                                Price ID
                            </td>

                            <td class="p-2">
                                {{ $subscription->stripe_price }}
                            </td>
                        </tr>

                        <tr class="border">
                            <td class="p-2 font-bold">
                                Trial Ends
                            </td>

                            <td class="p-2">

                                {{ $subscription->trial_ends_at
                ?? 'No Trial' }}

                            </td>
                        </tr>

                        <tr class="border">
                            <td class="p-2 font-bold">
                                Ends At
                            </td>

                            <td class="p-2">

                                {{ $subscription->ends_at
                ?? 'Active' }}

                            </td>
                        </tr>

                    </table>

                    <div class="mt-4">

                        <a href="/cancel-subscription" class="bg-red-500 text-white px-4 py-2 rounded"
                            style="background-color: rgb(254, 69, 45);">

                            Cancel Subscription

                        </a>

                    </div>

            @elseif(auth()->user()->subscription('default'))

                <div class="mb-4 p-4 bg-red-100 rounded">

                    <p class="text-red-700 font-bold">
                        Plan Cancelled
                    </p>

                </div>

            @else

                <div class="mb-4 p-4 bg-yellow-100 rounded">

                    <p class="text-yellow-700 font-bold">
                        No Subscription Found
                    </p>

                </div>

            @endif

        </div>

    </div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>