<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Loans') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Loan Information') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __("Create a new mortgage loan.") }}
                            </p>
                        </header>

                        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                            @csrf
                        </form>

                        <form method="post" action="{{ route('loans.store') }}" class="mt-6 space-y-6">
                            @csrf
                            @method('post')

                            <div>
                                <x-input-label for="amount" :value="__('Principal')" />
                                <x-text-input id="amount" name="amount" type="number" step="0.01" class="mt-1 block w-full" required autofocus autocomplete="Principal" />
                                <x-input-error class="mt-2" :messages="$errors->get('principal')" />
                            </div>

                            <div>
                                <x-input-label for="annual_interest_rate" :value="__('Annual Interest rate')" />
                                <x-text-input id="annual_interest_rate" name="annual_interest_rate" type="number" step="0.01" class="mt-1 block w-full" required autofocus autocomplete="Annual interest rate" />
                                <x-input-error class="mt-2" :messages="$errors->get('annual_interest_rate')" />
                            </div>

                            <div>
                                <x-input-label for="loan_term" :value="__('Loan term')" />
                                <x-text-input id="loan_term" name="loan_term" type="number" step="0.01" class="mt-1 block w-full" required autofocus autocomplete="Loan term" />
                                <x-input-error class="mt-2" :messages="$errors->get('loan_term')" />
                            </div>

                            <div>
                                <x-input-label for="monthly_fixed_extra_payment" :value="__('Monthly fixed extra payment')" />
                                <x-text-input id="monthly_fixed_extra_payment" name="monthly_fixed_extra_payment" type="number" step="0.01" class="mt-1 block w-full" required autofocus autocomplete="Monthly fixed extra payment" />
                                <x-input-error class="mt-2" :messages="$errors->get('monthly_fixed_extra_payment')" />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>

                                @if (session('status') === 'loan-created')
                                    <p
                                        x-data="{ show: true }"
                                        x-show="show"
                                        x-transition
                                        x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-600 dark:text-gray-400"
                                    >{{ __('Saved.') }}</p>
                                @endif
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
