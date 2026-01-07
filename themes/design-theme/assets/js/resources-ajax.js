jQuery(function ($) {
  //    STATE
  let selectedTopics = [];
  //  CORE AJAX LOAD
  function loadResources(page = 1) {
    const search = $('input[name="s"]').val();

    $("#resources-ajax-wrapper").addClass("opacity-50 pointer-events-none");

    $.ajax({
      url: RESOURCES_AJAX.ajax_url,
      type: "POST",
      data: {
        action: "load_resources",
        page: page,
        topics: selectedTopics,
        search: search,
      },
      success: function (res) {
        if (res.success) {
          $("#resources-ajax-wrapper").html(res.data);

          const filter = document.querySelector(".resources-filter");
          if (filter) {
            filter.scrollIntoView({
              behavior: "smooth",
              block: "start",
            });
          }
        }
      },
      complete: function () {
        $("#resources-ajax-wrapper").removeClass(
          "opacity-50 pointer-events-none"
        );
      },
    });
  }

  // PAGINATION CLICK (AJAX)
  $(document).on("click", ".resources-pagination a", function (e) {
    e.preventDefault();

    let page = $(this).data("page");

    if (!page) {
      const href = $(this).attr("href");
      const match = href && href.match(/\/page\/(\d+)/);
      if (match) page = match[1];
    }

    if (!page) return;

    loadResources(page);
  });
  let searchTimeout = null;

  $(document).on("input", 'input[name="s"]', function () {
    clearTimeout(searchTimeout);

    searchTimeout = setTimeout(() => {
      loadResources(1);
    }, 400);
  });

  // TOPIC DROPDOWN TOGGLE
  $(document).on("click", ".topic-toggle", function (e) {
    e.stopPropagation();
    $(".topic-dropdown").toggleClass("hidden");
  });

  // Click ra ngoài thì đóng dropdown
  $(document).on("click", function (e) {
    if (!$(e.target).closest(".topic-filter").length) {
      $(".topic-dropdown").addClass("hidden");
    }
  });

  // TOPIC CHECKBOX CHANGE
  $(document).on("change", ".topic-checkbox", function () {
    const value = $(this).val();

    if (this.checked) {
      if (!selectedTopics.includes(value)) {
        selectedTopics.push(value);
      }
    } else {
      selectedTopics = selectedTopics.filter((v) => v !== value);
    }

    renderTopicChips();
    loadResources(1);
  });

  //    RENDER TOPIC CHIPS
  function renderTopicChips() {
    const wrap = $(".topic-selected");
    wrap.html("");

    selectedTopics.forEach((slug) => {
      wrap.append(`
        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm flex items-center gap-2">
          ${slug.replace(/-/g, " ")}
          <button
            type="button"
            class="remove-topic"
            data-slug="${slug}"
          >
            &times;
          </button>
        </span>
      `);
    });
  }

  //    REMOVE CHIP
  $(document).on("click", ".remove-topic", function () {
    const slug = $(this).data("slug");

    selectedTopics = selectedTopics.filter((v) => v !== slug);
    $(`.topic-checkbox[value="${slug}"]`).prop("checked", false);

    renderTopicChips();
    loadResources(1);
  });
});
