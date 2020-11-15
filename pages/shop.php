<link rel="stylesheet" href="css/vertical_menu.css">



<div class="sidenav">
    <?php

    use entities\Category;

    function loadCategory(Category $category)
    {

        if (count($category->getChildren()) == 0) {
            echo "<a href=#category={$category->getId()}>{$category->getName()} </a>";
        } else {
            echo "<button class='dropdown-btn'>{$category ->getName()}";
            echo " </button>";
            echo "<div class='dropdown-container'>";
            foreach ($category->getChildren() as $cat) {
                echo "<a href=#category={$cat->getId()}>{$cat->getName()} </a>";
            }
            echo "</div>";
        }

    }


    $categories = Category::getAll();

    foreach ($categories as $category) {
        loadCategory($category);
    }
    ?>


    <script>
        var dropdown = document.getElementsByClassName("dropdown-btn");
        var i;

        for (i = 0; i < dropdown.length; i++) {
            dropdown[i].addEventListener("click", function () {
                this.classList.toggle("active");
                var dropdownContent = this.nextElementSibling;
                if (dropdownContent.style.display === "block") {
                    dropdownContent.style.display = "none";
                } else {
                    dropdownContent.style.display = "block";
                }
            });
        }
    </script>

</div>