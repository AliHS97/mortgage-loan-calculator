<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Amortization Schedule') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Amortization Schedule') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __("Loan Amount: ") . $loan->amount}} $.
                            </p>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __("Annual Interest Rate: ") . $loan->annual_interest_rate }}%.
                            </p>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __("Loan Term: ") . $loan->loan_term }} years.
                            </p>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __("Effective Interest Rate: ") . $loan->annual_interest_rate}}%.
                            </p>
                        </header>

                        @if($schedule->count())
                            <table class="table table-striped">
                              <thead>
                                  <tr>
                                      <th scope="col">#</th>
                                      <th scope="col">Month</th>
                                      <th scope="col">Starting Balance</th>
                                      <th scope="col">Monthly Payment</th>
                                      <th scope="col">Principal Payment</th>
                                      <th scope="col">Interest Payment</th>
                                      <th scope="col">Extra Payment Amount</th>
                                      <th scope="col">Ending Balance</th>
                                      <th scope="col">Extra Payment</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <form method="post" action="{{ route('loans.extra.payment', ['loan' => $loan->id]) }}">
                                      @csrf
                                      @foreach($schedule as $item)
                                          <div class="input-group">
                                          <tr>
                                              <th scope="row">{{$item->id}}</th>
                                              <td>{{$item->month}}</td>
                                              <td>{{$item->starting_balance}}$</td>
                                              <td>{{$item->monthly_payment}}$</td>
                                              <td>{{$item->principal_payment}}$</td>
                                              <td>{{$item->interest_payment}}$</td>
                                              <td>{{$item->extra_repayment ?? 0}}$</td>
                                              <td>{{$item->ending_balance}}$</td>
                                              <td style="text-align: center !important;">
                                                  <input class="form-check-input" type="checkbox" name="extraPaymentMonths[]" value="{{$item->month}}" {{$item->extra_repayment ? "checked" : ""}}>
                                              </td>
                                          </tr>
                                          </div>
                                      @endforeach
                                      <div class="input-group m-3">
                                          <button type="submit" class="btn btn-light">Update</button>
                                      </div>
                                  </form>
                              </tbody>
                          </table>
                        @endif
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
