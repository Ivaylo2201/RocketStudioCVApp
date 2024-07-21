<script>
    const addUniversity = document.getElementById("add-university");
    const addUniversityButton = document.getElementById("add-university-button");
    const addTechnology = document.getElementById("add-technology");
    const addTechnologyButton = document.getElementById("add-technology-button");
    const universitiesSelect = document.getElementById("university");
    const technologiesSelect = document.getElementById("technologies");

    const toggleVisibility = (elementId) => {
        const element = document.getElementById(elementId);

        const currentVisibility = element.style.visibility;
        let toggledVisibility = null;

        if (currentVisibility === "hidden")
            toggledVisibility = "visible";
        else
            toggledVisibility = "hidden";

        element.style.visibility = toggledVisibility;
    };

    const fetchData = async (url, body) => {
        try {
            const response = await fetch(url, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify(body),
            });


            if (!response.ok) {
                throw new Error(`An error occurred`);
            }

            return await response.json();

        } catch (error) {
            console.error(error);
        }
    };

    addUniversity.addEventListener("click", () => {
        toggleVisibility("add-university-popup");
    });

    addTechnology.addEventListener("click", () => {
        toggleVisibility("add-technology-popup");
    });

    addUniversityButton.addEventListener("click", async () => {
        const universityName = document.getElementById("university-name").value;
        const grade = document.getElementById("grade").value;

        const url = "{{ route('add.university') }}";
        const body = {
            name: universityName,
            grade: grade
        }

        const data = await fetchData(url, body);

        if (data && data.created) {
            const option = document.createElement("option");
            option.value = data.university.name;
            option.textContent = data.university.name;
            option.setAttribute("grade", data.university.grade);
            universitiesSelect.appendChild(option);
        }
    });

    addTechnologyButton.addEventListener("click", async () => {
        const technologyName = document.getElementById("technology-name").value;

        const url = "{{ route('add.technology') }}";
        const body = {
            name: technologyName
        };

        const data = await fetchData(url, body);

        if (data && data.created) {
            const option = document.createElement("option");
            option.value = data.technology.name;
            option.textContent = data.technology.name;
            technologiesSelect.appendChild(option);
        }
    });
</script>