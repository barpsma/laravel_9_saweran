<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Saweran</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

    <style>
        body {
            min-height: 75rem;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="/">Saweran</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="/sawer">Nyawer <span class="sr-only">(current)</span></a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="jumbotron">
        <div class="container">
            <h1 class="display-4">Saweran</h1>
            <p class="lead">Platform saweran untuk siapa saja.</p>
        </div>
    </div>

    <div class="container">
        <table class="table table-striped" id="list">
            <tr>
                <th>ID</th>
                <th>Penyawer</th>
                <th>Amount</th>
                <th>Sawer Type</th>
                <th>Status</th>
                <th style="text-align: center;"></th>
            </tr>
            @foreach ($sawerans as $saweran)
            <tr>
                <td><code>{{ $saweran->id }}</code></td>
                <td>{{ $saweran->sawer_name }}</td>
                <td>Rp. {{ number_format($saweran->amount) }},-</td>
                <td>{{ ucwords(str_replace('_', ' ', $saweran->sawer_type)) }}</td>
                <td>{{ ucfirst($saweran->status) }}</td>
                <td style="text-align: center;">
                    @if ($saweran->status == 'pending')
                    <button class="btn btn-success btn-sm" onclick="snap.pay('{{ $saweran->snap_token }}')">Complete Payment</button>
                    @endif
                </td>
            </tr>
            @endforeach
            <tr>
                <td colspan="6">{{ $sawerans->links() }}</td>
            </tr>
        </table>
    </div>



    <script src="https://code.jquery.com/jquery-3.4.1.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js">
    </script>
    <script src="{{
        !config('services.midtrans.isProduction') ? 'https://app.sandbox.midtrans.com/snap/snap.js' : 'https://app.midtrans.com/snap/snap.js' }}"
        data-client-key="{{ config('services.midtrans.clientKey')
    }}"></script>
</body>

</html>