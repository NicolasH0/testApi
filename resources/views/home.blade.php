@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form id="form" action="" method="POST">
                @csrf
                <div class="form-group">
                    <label for="age">Your age</label>
                    <input id="age" name="age" type="text">
                </div>

                <div class="form-group">
                    <label for="currency">Currency</label>
                    <input id="currency" name="currency" type="text" placeholder="USD, EUR OR GBP">
                </div>

                <div class="form-group">
                    <label for="startDate">Starting date</label>
                    <input id="startDate" name="startDate" type="text" value="2020-10-01" disabled>
                </div>

                <div class="form-group">
                    <label for="endDate">Ending date</label>
                    <input id="endDate" name="endDate" type="text" value="2020-10-30" disabled>
                </div>

                <button type="submit">Send data</button>
            </form>
        </div>
    </div>
    <div class="container">
        <div class="alert alert-danger" role="alert" id="errorSection" style="display: none">
            <p id="error"></p>
        </div>
        <div class="alert alert-success" role="alert" id="successSection" style="display:none;">
            <span>Total:</span>
            <span id="price"></span>
            <span id="cur"></span>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#form").submit(function (event) {
            var formData = {
                name: $("#name").val(),
                email: $("#age").val(),
                date: $("#date").val(),
                currency: $("#currency").val(),
            };
            $.ajax({
                method: "POST",
                url: "/getQuote",
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type': 'application/json',
                    'Authorization': '{{ env('JWT_SECRET') }}'
                },
                data: JSON.stringify(formData),
                dataType: "json",
                encode: true,
            }).done(function (data) {
                let result = JSON.parse(JSON.stringify(data))
                if(result['success'] === true){
                    $("#errorSection").hide()
                    $("#successSection").show()
                    $("#price").text(result['total'])
                    $("#cur").text(result['currency_id'])
                } else {
                    $("#successSection").hide()
                    $("#errorSection").show()
                    $("#error").text(result['errorMessage'])
                }
            });

            event.preventDefault();
        });
    });
</script>
@endsection
