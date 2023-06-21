<html>
    
<body>
    <h1>{{ $title }}</h1>
    
    <p>{{ $place }}</p>
    <p>{{ $date }}</p>
    <p>{{ $time }}</p>
    <p>
    <img src="{{ $message->embed($imagePath) }}" alt="Embedded Image">
    </p>
    Nama     : {{ $member_name }}
    Nosis    : {{ $nosis }}
    Angkatan : {{ $batch }}
</body>
</html>