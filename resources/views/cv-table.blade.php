<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/cv-table.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/b53851d4fb.js" crossorigin="anonymous"></script>
    <title>Document</title>
</head>

<body>
    <main>
        <h2>Моля, въведете начална и крайна дата:</h2>

        <a href="/">
            <i class="fa-solid fa-arrow-left"></i>
            Към форма за CV
        </a>

        @include('components.table-page.date-period-form')

        <table>
            @include('components.table-page.table-people-headers')
            @include('components.table-page.table-people-values')
        </table>

        <table>
            @include('components.table-page.table-ages-headers')
            @include('components.table-page.table-ages-values')
        </table>
    </main>
</body>

</html>