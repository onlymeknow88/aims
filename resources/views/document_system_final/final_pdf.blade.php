<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        @page {
            margin: 0;
        }
        body {
            margin: 0;
            padding: 20px;
        }

        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            width: 150mm;
            opacity: 0.2;
            transform: translateX(-50%) translateY(-50%) rotate(-45deg);
        }
    </style>
</head>

<body>

    <img src="{{ $watermark }}" class="watermark" />

</body>

</html>
