
<div align="middle">
    <div class="visible-print text-center">
        <img align="middle" src="data:image/png;base64, {{ base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(700)->generate($event['qr'])) }} ">
        <h1>{{$event['name']}}</h1>
    </div>
</div>