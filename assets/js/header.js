document.addEventListener("DOMContentLoaded", function () {
  const srs_hamburg_btn = document.querySelector(".srs_hamburg");
  const srs_mobile_menu = document.querySelector(".srs_mobile_menu_pr");
  const srs_mobile_sub_menu = document.querySelector(
    ".srs_mobile_menu_pr.srs_sub_menu"
  );
  const srs_all_courses = document.querySelector(
    ".srs_items-container.srs_all_courses"
  );
  const srs_overlay = document.querySelector(".srs_overlay_mobile");
  const srs_back_to_menu = document.querySelector(".srs_backToMenu");
  const srs_search = document.querySelector(".srs_search");
  const srs_mobile_search = document.querySelector(".srs_mobile_search");
  const nameElement = document.getElementById("nameDisplay");
  let name;

  if (nameElement && nameElement.textContent) {
    name = nameElement.textContent.trim();
  }
  
  const nameElement2 = document.getElementById("nameDisplay2");
  let name2;

  if (nameElement2 && nameElement2.textContent) {
    name2 = nameElement2.textContent.trim();
  }
  if (nameElement && nameElement.textContent){
    nameElement.textContent = name.charAt(0);
  }
  if (nameElement2 && nameElement2.textContent) {
    nameElement2.textContent = name2.charAt(0);
  }


  document.addEventListener("scroll", function () {
    const header = document.querySelector(".srs_header_pr");
    const srs_scrollPosition = window.scrollY;

    if (srs_scrollPosition > 70) {
      header.classList.add("fixed");
    } else {
      header.classList.remove("fixed");
    }
  });

  srs_hamburg_btn.addEventListener("click", function () {
    srs_overlay.classList.add("open");
    srs_mobile_menu.classList.add("open");
  });

  srs_search.addEventListener("click", function () {
    srs_mobile_search.classList.add("open");
  });

  srs_all_courses.addEventListener("click", function () {
    srs_mobile_sub_menu.classList.add("open");
  });

  srs_back_to_menu.addEventListener("click", function () {
    srs_mobile_sub_menu.classList.remove("open");
  });

  srs_overlay.addEventListener("click", function () {
    srs_mobile_menu.classList.remove("open");
    srs_overlay.classList.remove("open");
    srs_mobile_sub_menu.classList.remove("open");
    srs_mobile_search.classList.remove("open");
  });

  const srs_cross = document.querySelectorAll(".srs_cross");
  srs_cross.forEach(function (item) {
    item.addEventListener("click", function () {
      srs_mobile_menu.classList.remove("open");
      srs_overlay.classList.remove("open");
      srs_mobile_sub_menu.classList.remove("open");
      srs_mobile_search.classList.remove("open");
    });
  });
});
