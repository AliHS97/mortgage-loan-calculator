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
                                {{ __('Loans') }}
                            </h2>
                        </header>

                        @if($loans->count())
                            <table class="table table-striped">
                              <thead>
                                  <tr>
                                      <th scope="col">#</th>
                                      <th scope="col">Amount</th>
                                      <th scope="col">Annual Interest Rate</th>
                                      <th scope="col">Loan Term</th>
                                      <th scope="col">Monthly Fixed Extra Payment</th>
                                      <th scope="col">Details</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  @foreach($loans as $loan)
                                      <tr>
                                          <th scope="row">#</th>
                                          <td>{{$loan->amount}}</td>
                                          <td>{{$loan->annual_interest_rate}}</td>
                                          <td>{{$loan->loan_term}}</td>
                                          <td>{{$loan->monthly_fixed_extra_payment}}</td>
                                          <td>
                                            <x-nav-link :href="route('loans.amortization.schedule', ['loan' => $loan->id])">
                                                {{ __('Amortization') }}
                                            </x-nav-link>
                                          </td>
                                      </tr>
                                  @endforeach
                              </tbody>
                          </table>
                        @endif
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
