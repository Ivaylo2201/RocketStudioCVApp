<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/form-page.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/b53851d4fb.js" crossorigin="anonymous"></script>
    <title>Document</title>
</head>

<body>
    <main>
        <form action="{{ route('form.submit') }}" method="POST">
            @csrf
            <h1>Създаване на CV</h1>
            <section class="section-names">
                <input type="text" name="first_name" id="first_name" placeholder="Име...">
                <input type="text" name="middle_name" id="middle_name" placeholder="Презиме...">
                <input type="text" name="last_name" id="last_name" placeholder="Фамилия...">
            </section>
            <section class="section-date-of-birth">
                <p>Дата на раждане</p>
                <input type="date" name="date_of_birth" id="date_of_birth">
            </section>
            <section class="section-university">
                <select name="university" id="university">
                    <option value="tu-varna">TU-VARNA</option>
                    <option value="marine">Marine</option>
                </select>
                <span id="add-university">
                    <i class="fa-solid fa-pencil"></i>
                </span>
                <div id="add-university-window">
                    <p>Popup въвеждане на нов Университет</p>
                    <input type="text" name="university-name" id="university-name" placeholder="Име на университет...">
                    <input type="text" name="grade" id="grade" placeholder="Акредедитационна оценка...">
                    <button id="add-university-button">Запис</button>
                </div>
            </section>
            <section class="section-technologies">
                <select id="technologies" name="technologies[]" multiple>
                    <option value="php">PHP</option>
                    <option value="laravel">Laravel</option>
                    <option value="symfony">Symfony</option>
                    <option value="zend">Zend framework</option>
                    <option value="ruby">Ruby</option>
                    <option value="mysql">MySql</option>
                    <option value="css3">CSS3</option>
                </select>
                <span>
                    <i class="fa-solid fa-pencil"></i>
                </span>
            </section>
            <section class="section-button">
                <button type="submit">Запис на CV</button>
            </section>
        </form>
    </main>
    <script>
        const addUniversity = document.getElementById("add-university");
        const window = document.getElementById('add-university-window');
        const addUniversityButton = document.getElementById('add-university-button');

        addUniversity.addEventListener('click', () => {
            const window = document.getElementById('add-university-window');
            window.style.display = window.style.display === 'none' ? 'block' : 'none';
        });
    </script>
</body>

</html>