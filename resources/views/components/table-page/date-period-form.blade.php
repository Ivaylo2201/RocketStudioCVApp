<form action="{{ route('cvs.table') }}" method="GET">
    <section class="inputs">
        <label for="start_date" style="font-weight: bold;">Начална дата:</label>
        <input required type="date" name="start_date" id="start_date">
        <label for="end_date" style="font-weight: bold;">Крайна дата:</label>
        <input required type="date" name="end_date" id="end_date">
    </section>
    <button type="submit">Търси CV-та</button>
</form>