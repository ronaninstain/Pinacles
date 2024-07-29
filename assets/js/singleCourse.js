/* cirruculum expand btn start */

document
  .getElementById("expandAllSections")
  .addEventListener("click", function () {
    const panels = document.querySelectorAll(".panel-collapse");
    const expandAll = this.getAttribute("data-expanded") !== "true";

    panels.forEach((panel) => {
      if (expandAll) {
        panel.classList.add("in");
        panel.setAttribute("aria-expanded", "true");
      } else {
        panel.classList.remove("in");
        panel.setAttribute("aria-expanded", "false");
      }
    });

    this.setAttribute("data-expanded", expandAll);
    this.textContent = expandAll
      ? "Collapse all sections"
      : "Expand all sections";
  });

/* cirruculum expand btn end */

/* comments load more btn start */

let isExpanded = false;

function loadMoreReviews() {
  const comments = document.querySelectorAll(".commentBox");
  const loadMoreBtn = document.getElementById("loadMoreBtn");

  if (isExpanded) {
    comments.forEach((comment, index) => {
      if (index >= 3) {
        comment.classList.add("hidden");
      }
    });
    loadMoreBtn.textContent = "Load more reviews";
  } else {
    comments.forEach((comment) => comment.classList.remove("hidden"));
    loadMoreBtn.textContent = "Show less";
  }

  isExpanded = !isExpanded;
}

/* comments load more btn end */

/* Share popup start */

document.getElementById("shareBtn").addEventListener("click", function () {
  document.getElementById("sharePopup").style.display = "flex";
});

document.querySelector(".close-btn").addEventListener("click", function () {
  document.getElementById("sharePopup").style.display = "none";
});

document.querySelector(".copy-btn").addEventListener("click", function () {
  const copyText = document.querySelector(".share-popup input");
  copyText.select();
  copyText.setSelectionRange(0, 99999); // For mobile devices
  document.execCommand("copy");
  alert("Copied the link: " + copyText.value);
});

/* Share popup end */

// side bar 


document.addEventListener("DOMContentLoaded", function () {
  window.addEventListener("scroll", function () {
  if (window.innerWidth > 991) {
    const courseSidebar = document.querySelector(".apexLearningSinglePageSideBar");
    const courseSidebarImage = document.querySelector(".apexLearningSinglePageSideBar .courseImage");
    const floatingTitleBox = document.querySelector(".r-floating-title-box-h");
    
    const scrollTop =
      window.pageYOffset || document.documentElement.scrollTop;
    const parentDiv = document.querySelector(".courseMiddle");
    const parentDivBottom = parentDiv.offsetTop + parentDiv.offsetHeight;

    if (
      scrollTop > 100 &&
      scrollTop < parentDivBottom - courseSidebar.offsetHeight
    ) {
      const parentDivTop = parentDiv.offsetTop;
      const sidebarTop = scrollTop - parentDivTop + "px";
      courseSidebar.style.position = "absolute";
      courseSidebar.style.top = sidebarTop;
      courseSidebar.style.marginTop = "100px";
      courseSidebarImage.style.display = "none";
      courseSidebar.style.zIndex="4";
      floatingTitleBox.classList.add("fixedBox");
    } else if (scrollTop >= parentDivBottom - courseSidebar.offsetHeight) {
      courseSidebar.style.position = "relative";
      courseSidebar.style.top =
        parentDiv.offsetHeight - courseSidebar.offsetHeight + "px";
        courseSidebar.style.marginTop = "0";
        courseSidebarImage.style.display = "block";
        floatingTitleBox.classList.remove("fixedBox");
    } else {
      courseSidebar.style.position = "static";
      courseSidebar.style.marginTop = "-347px";
      courseSidebarImage.style.display = "block";
      floatingTitleBox.classList.remove("fixedBox");
    }
  } else {
    const courseSidebar = document.querySelector(".apexLearningSinglePageSideBar");
    courseSidebar.removeAttribute("style");
  }
});
});
// Side bar end 

// Div Collapse 
document.getElementById('theContentBoxToggle').addEventListener('click', function() {
  var contentBox = document.querySelector('.theContentBox');
  if (contentBox.classList.contains('expanded')) {
      contentBox.classList.remove('expanded');
      this.classList.remove('expanded');
      this.textContent = 'Show more';
  } else {
      contentBox.classList.add('expanded');
      this.classList.add('expanded');
      this.textContent = 'Show less';
  }
});
