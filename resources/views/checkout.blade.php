@extends('layouts.front')
@section('stylesheets')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection

@section('content')
    <div class="container">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <h2>Dados para pagamento</h2>
                </div>
            </div>
            <hr>
            <form action="" method="post">
                <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nome no cartao </label>
                                <input type="text" class="form-control" name="card_name">
                            </div>
                        </div>


                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Numero do cartao <span class="brand"></span> </label>
                                <input type="text" class="form-control" name="card_number">
                                <input type="hidden" name="card_brand">
                            </div>
                        </div>

                    <div class="row">
                        <div class=" col-md-5 form-group">
                            <label>Mes de expiracao</label>
                            <input type="text" class="form-control" name="card_month">
                        </div>
                        <div class=" col-md-5 form-group">
                            <label>ano de expiracao</label>
                            <input type="text" class="form-control" name="card_year">
                        </div>
                    </div>
                    <div class="row">
                        <div class=" col-md-6 form-group">
                            <label>Codigo de seguranca</label>
                            <input type="text" class="form-control" name="card_cvv">
                        </div>
                        <div class="col-md-12 installments form-group"></div>
                    </div>
                </div>
                <button class="btn btn-success btn-lg processCheckout">Efetuar pagamento</button>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script
        src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
    <script
        src="https://code.jquery.com/jquery-2.2.4.min.js"
        integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
        crossorigin="anonymous"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        const sessionId = '{{session()->get('pagseguro_session_code')}}';
        PagSeguroDirectPayment.setSessionId(sessionId);
    </script>

    <script>
        let amountTransaction = '{{$cartItems}}';
        let cardNumber = document.querySelector('input[name=card_number]');
        let spanBrand = document.querySelector('span.brand')
        cardNumber.addEventListener('keyup', function () {
            if (cardNumber.value.length >= 6) {
                PagSeguroDirectPayment.getBrand({
                    cardBin: cardNumber.value.substr(0, 6),
                    success: function (res) {
                        let imgFlag = `<img src="https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/${res.brand.name}.png">`;
                        spanBrand.innerHTML = imgFlag;
                        document.querySelector('input[name=card_brand]').value = res.brand.name;
                        getInstallments(amountTransaction, res.brand.name);
                    },
                    error: function (err) {
                        console.log(err);
                    },
                    complete: function (res) {
                        console.log('Complete: ' + res);
                    }
                });
            }
        });

        let submitButton = document.querySelector('button.processCheckout');

        submitButton.addEventListener('click', function (event) {
            event.preventDefault();

            PagSeguroDirectPayment.createCardToken({
                cardNumber: document.querySelector('input[name=card_number]').value,
                brand: document.querySelector('input[name=card_brand]').value,
                cvv: document.querySelector('input[name=card_cvv]').value,
                expirationMonth: document.querySelector('input[name=card_month]').value,
                expirationYear: document.querySelector('input[name=card_year]').value,
                success: function (res) {
                    console.log(res);
                    proccessPayment(res.card.token)
                }
            })
        })

        function proccessPayment(token) {
            let data = {
                card_token: token,
                hash: PagSeguroDirectPayment.getSenderHash(),
                installment: document.querySelector('select.select_installments').value,
                card_name: document.querySelector('input[name=card_name]').value,
                _token: '{{csrf_token()}}'
            };
            $.ajax({
                type: 'POST',
                url: '{{route('checkout.proccess')}}',
                data: data,
                dataType: 'json',
                success: function (res) {
                    // Display a success toast, with a title
                    toastr.success(res.data.message, 'Sucesso')
                    window.location.href = '{{route('checkout.thanks')}}?order=' + res.data.order;
                }
            })
        }

        function getInstallments(amount, brand) {
            PagSeguroDirectPayment.getInstallments({
                amount: amount,
                brand: brand,
                maxInstallmentNoInterest: 0,
                success: function (res) {
                    let selectInstallments = drawSelectInstallments(res.installments[brand]);
                    document.querySelector('div.installments').innerHTML = selectInstallments;
                },
                error: function (err) {
                    console.log(err);
                },
                complete: function (res) {
                    console.log('Complete: ' + res);
                }
            })
        }

        function drawSelectInstallments(installments) {
            let select = '<label>Opções de Parcelamento:</label>';

            select += '<select class="form-control select_installments">';

            for (let l of installments) {
                select += `<option value="${l.quantity}|${l.installmentAmount}">${l.quantity}x de ${l.installmentAmount} - Total fica ${l.totalAmount}</option>`;
            }

            select += '</select>';

            return select;
        }
    </script>
@endsection
