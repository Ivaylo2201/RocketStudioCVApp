<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/cv-table.css') }}" rel="stylesheet">
    <title>Document</title>
</head>

<body>
    <main>
        <h2>Моля, въведете начална и крайна дата</h2>

        <form action="{{ route('cvs.table') }}" method="GET">
            <section>
                <label for="start_date">Начална дата:</label>
                <input type="date" name="start_date" id="start_date">
                <label for="end_date">Крайна дата:</label>
                <input type="date" name="end_date" id="end_date">
            </section>
            <button type="submit">Търси CV-та</button>
        </form>

        <table>
            <tr>
                <th>Пореден номер на CV</th>
                <th>Дата на създаване на CV</th>
                <th>Име на лицето</th>
                <th>Презиме на лицето</th>
                <th>Фамилия на лицето</th>
                <th>Дата на раждане</th>
                <th>Завършен университет</th>
                <th>Технологии</th>
            </tr>
            @foreach ($cvs as $cv)
            <tr>
                <td>{{ $cv->id }}</td>
                <td>{{ $cv->created_at }}</td>
                <td>{{ $cv->person->first_name }}</td>
                <td>{{ $cv->person->middle_name }}</td>
                <td>{{ $cv->person->last_name }}</td>
                <td>{{ $cv->person->date_of_birth }}</td>
                <td>{{ $cv->person->university->name }}</td>
                <td>
                    @if ($cv->person->technologies->isNotEmpty())
                        {{ $cv->person->technologies->pluck('name')->implode(', ') }}
                    @else
                        Няма записани технологии
                    @endif
                </td>
            </tr>
            @endforeach
        </table>
    </main>
</body>

</html>