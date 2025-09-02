@foreach($messages as $msg)
    <div class="notification {{ $msg['status'] }}">
        <h4>{{ $msg['title'] }}</h4>
        <p>{{ $msg['message'] }}</p>
        <span>{{ $msg['time'] }}</span>
    </div>
@endforeach
