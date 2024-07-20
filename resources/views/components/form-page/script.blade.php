<script>
    const addUniversity = document.getElementById("add-university");
    const addUniversityButton = document.getElementById("add-university-button");
    const addTechnology = document.getElementById("add-technology");
    const addTechnologyButton = document.getElementById("add-technology-button");
    const universitiesSelect = document.getElementById("university");
    const technologiesSelect = document.getElementById("technologies");

    addUniversity.addEventListener("click", () => {
        const universityPopup = document.getElementById("add-university-popup");
        universityPopup.style.visibility =
            universityPopup.style.visibility === "hidden" ? "visible" : "hidden";
    });

    addTechnology.addEventListener("click", () => {
        const technologyPopup = document.getElementById("add-technology-popup");
        technologyPopup.style.visibility =
            technologyPopup.style.visibility === "hidden" ? "visible" : "hidden";
    });

    addUniversityButton.addEventListener("click", () => {
        const universityName = document.getElementById("university-name").value;
        const grade = document.getElementById("grade").value;

        fetch("{{ route('add.university') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                },
                body: JSON.stringify({
                    name: universityName,
                    grade: grade,
                }),
            })
            .then((response) => response.json())
            .then((data) => {
                if (data.created) {
                    const option = document.createElement("option");
                    option.value = data.university.name;
                    option.textContent = data.university.name;
                    option.setAttribute("grade", data.university.grade);
                    universitiesSelect.appendChild(option);
                }
            })
            .catch((err) => console.log(err));
    });

    addTechnologyButton.addEventListener("click", () => {
        const technologyName = document.getElementById("technology-name").value;

        fetch("{{ route('add.technology') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                },
                body: JSON.stringify({
                    name: technologyName,
                }),
            })
            .then((response) => response.json())
            .then((data) => {
                if (data.created) {
                    const option = document.createElement("option");
                    option.value = data.technology.name;
                    option.textContent = data.technology.name;
                    technologiesSelect.appendChild(option);
                }
            })
            .catch((err) => console.log(err));
    });
</script>