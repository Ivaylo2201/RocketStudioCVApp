<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/form-page.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/b53851d4fb.js" crossorigin="anonymous"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
</head>

<body>
    <main>
        <form action="{{ route('form.submit') }}" method="POST">
            @csrf
            <h1>Създаване на CV</h1>

            <section class="section-names">
                <input required type="text" name="first_name" id="first_name" placeholder="Име...">
                <input required type="text" name="middle_name" id="middle_name" placeholder="Презиме...">
                <input required type="text" name="last_name" id="last_name" placeholder="Фамилия...">
            </section>

            <section class="section-date-of-birth">
                <p>Дата на раждане</p>
                <input required type="date" name="date_of_birth" id="date_of_birth">
            </section>

            <section class="section-university">
                @include('components.form-page.universities-list')

                <span id="add-university">
                    <i class="fa-solid fa-pencil"></i>
                </span>

                @include('components.form-page.add-university-popup')
            </section>

            <section class="section-technologies">
                @include('components.form-page.technologies-list')

                <span id="add-technology">
                    <i class="fa-solid fa-pencil"></i>
                </span>

                @include('components.form-page.add-technology-popup')
            </section>

            <section class="section-button">
                <button type="submit" id="submit-button">Запис на CV</button>
            </section>
        </form>

        <a href="/table">
            Към таблица със CV-та
            <i class="fa-solid fa-arrow-right"></i>
        </a>
    </main>
    
    <script src="{{ asset('js/script.js') }}"></script>

</body>

</html>