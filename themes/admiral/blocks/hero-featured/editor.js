const { __ } = wp.i18n;
const { InspectorControls } = wp.blockEditor;
const {
  PanelBody,
  RadioControl,
  TextControl,
  RangeControl,
  ToggleControl,
  SelectControl,
  ColorPicker,
  ColorPalette,
  Button,
  Dropdown,
  CheckboxControl,
} = wp.components;
const { FormTokenField } = wp.components;
const { Fragment, createElement, useState } = wp.element;
const { useSelect } = wp.data;
const { ServerSideRender } = wp.serverSideRender;
const FONT_WEIGHT_OPTIONS = [
  { label: "Nhẹ (300)", value: "300" },
  { label: "Thường (400)", value: "400" },
  { label: "Trung bình (500)", value: "500" },
  { label: "Đậm (600)", value: "600" },
  { label: "Rất đậm (700)", value: "700" },
  { label: "Siêu đậm (800)", value: "800" },
];

//  COMPONENT: ColorControlCompact – Bộ chọn màu gọn
const ColorControlCompact = ({ label, value, onChange }) => {
  const [open, setOpen] = useState(false);

  const togglePicker = () => setOpen(!open);

  return createElement(
    "div",
    { style: { marginBottom: "16px" } },

    // ----- LABEL -----
    createElement(
      "label",
      {
        style: {
          display: "block",
          fontWeight: "600",
          marginBottom: "6px",
        },
      },
      label
    ),

    // ----- HÀNG CHỨA Ô MÀU + MÃ HEX -----
    createElement(
      "div",
      {
        style: {
          display: "flex",
          alignItems: "center",
          gap: "8px",
          cursor: "pointer",
        },
        onClick: togglePicker,
      },

      // Ô màu
      createElement("div", {
        style: {
          width: "26px",
          height: "26px",
          borderRadius: "4px",
          border: "1px solid #ccc",
          background: value,
        },
      }),

      // Mã màu
      createElement(
        "div",
        {
          style: {
            fontFamily: "monospace",
            fontSize: "14px",
          },
        },
        value
      )
    ),

    // ----- COLOR PICKER -----
    open &&
      createElement(
        "div",
        {
          style: {
            marginTop: "8px",
            padding: "10px",
            background: "#fff",
            border: "1px solid #ddd",
            borderRadius: "6px",
          },
        },
        createElement(ColorPicker, {
          color: value,
          onChangeComplete: (col) => onChange(col.hex),
        })
      )
  );
};
function decodeHtml(html) {
  const txt = document.createElement("textarea");
  txt.innerHTML = html;
  return txt.value;
}

//  BLOCK: HERO FEATURED
wp.blocks.registerBlockType("admiral/hero-featured", {
  edit: function (props) {
    const attributes = props.attributes;
    const setAttributes = props.setAttributes;
    const layout = attributes.layoutType || "slider";

    // Lấy bài viết từ WordPress
    const posts = useSelect((select) =>
      select("core").getEntityRecords("postType", "post", {
        per_page: 20,
        orderby: "date",
        order: "desc",
      })
    );

    // Lấy category từ WordPress
    const categories = useSelect((select) =>
      select("core").getEntityRecords("taxonomy", "category", {
        per_page: -1,
      })
    );

    // Lấy tag từ WordPress
    const tags = useSelect((select) =>
      select("core").getEntityRecords("taxonomy", "post_tag", {
        per_page: -1,
      })
    );

    // Map tag names to IDs
    const tagNames = tags ? tags.map((t) => t.name) : [];

    // Tạo map từ tên tag sang ID
    const tagNameToIdMap = tags
      ? tags.reduce((acc, t) => {
          acc[t.name] = String(t.id);
          return acc;
        }, {})
      : {};

    // Tạo options cho dropdown bài viết
    const postOptions = [
      { label: "Không ghim bài", value: 0 },
      ...(posts
        ? posts.map((p) => ({
            label: p.title.rendered || `(ID: ${p.id})`,
            value: p.id,
          }))
        : []),
    ];

    // Tạo options cho dropdown category
    const filteredCategories = categories
      ? categories.filter((cat) => String(cat.id) !== "1")
      : [];

    // Tạo options cho SelectControl category
    const categoryOptions = [
      { label: "Chọn danh mục", value: "" },
      ...filteredCategories.map((cat) => ({
        label: cat.name,
        value: String(cat.id),
      })),
    ];

    // State cho ô search bài viết ghim
    const [searchPinned, setSearchPinned] = useState("");

    // Lọc bài viết theo từ khoá search
    const filteredPosts = posts
      ? posts.filter((p) =>
          p.title.rendered.toLowerCase().includes(searchPinned.toLowerCase())
        )
      : [];
    // Lọc tag
    const filteredTags = tags || [];

    // Tạo options cho SelectControl tag
    const tagOptions = [
      { label: "Chọn tag", value: "" },
      ...filteredTags.map((tag) => ({
        label: tag.name,
        value: String(tag.id),
      })),
    ];

    // State cho ô search tag
    const [searchTag, setSearchTag] = useState("");

    /* LỌC TAG THEO SEARCH  */
    const filteredTagList = filteredTags.filter((tag) =>
      tag.name.toLowerCase().includes(searchTag.toLowerCase())
    );

    return createElement(
      Fragment,
      null,
      //  SIDEBAR (InspectorControls)
      createElement(
        InspectorControls,
        null,
        // PANEL 1: Cài đặt Slider
        createElement(
          PanelBody,
          { title: "Cài đặt block", initialOpen: true },
          // Ẩn hiện block
          createElement(ToggleControl, {
            label: "Ẩn block này",
            checked: attributes.hideBlock,
            onChange: (v) => setAttributes({ hideBlock: v }),
          }),
          // Tiêu đề label
          createElement(TextControl, {
            label: "Tiêu đề label",
            value: attributes.label,
            onChange: (v) => setAttributes({ label: v }),
          }),
          // Chọn kiểu hiển thị
          createElement(SelectControl, {
            label: "Chọn layout hiển thị",
            value: attributes.layoutType,
            options: [
              { label: "Slider", value: "slider" },
              { label: "Hero + Grid 3", value: "hero-grid" },
              { label: "Grid 6 bài", value: "grid-6" },
              { label: "Magazine Hero", value: "magazine-hero" },
            ],
            onChange: (v) => setAttributes({ layoutType: v }),
          }),
          createElement(
            "div",
            {},

            //Nhóm chọn nguồn bài viết
            createElement(
              "div",
              {
                style: {
                  fontSize: "11px",
                  fontWeight: "600",
                  textTransform: "uppercase",
                  color: "#1e1e1e",
                  marginBottom: "6px",
                },
              },
              "Nguồn bài viết"
            ),

            // Select chọn nguồn bài viết
            createElement(SelectControl, {
              value: attributes.sourceType || "",
              options: [
                { label: "Theo danh mục", value: "category" },
                { label: "Theo tag", value: "tag" },
              ],
              onChange: (v) =>
                setAttributes({
                  sourceType: v,
                  selectedCategories: [],
                  selectedTags: [],
                }),
            }),

            // Select thêm Danh mục khi chọn nguồn là Danh mục
            attributes.sourceType === "category" &&
              createElement(
                "div",
                { style: { marginTop: "10px" } },

                // Tag hiển thị Danh mục đã chọn
                createElement(
                  "div",
                  {
                    style: {
                      display: "flex",
                      flexWrap: "wrap",
                      gap: "6px",
                      marginBottom: "8px",
                    },
                  },
                  (attributes.selectedCategories || []).map((catId) => {
                    const cat = categories?.find(
                      (c) => String(c.id) === String(catId)
                    );
                    // Danh mục đã chọn
                    return createElement(
                      "span",
                      {
                        key: catId,
                        style: {
                          padding: "3px 8px",
                          background: "#eee",
                          borderRadius: "12px",
                          display: "flex",
                          alignItems: "center",
                          gap: "6px",
                        },
                      },

                      // Button xóa
                      createElement(
                        "button",
                        {
                          onClick: () =>
                            setAttributes({
                              selectedCategories:
                                attributes.selectedCategories.filter(
                                  (id) => id !== catId
                                ),
                            }),
                          style: {
                            border: "none",
                            background: "transparent",
                            cursor: "pointer",
                            fontWeight: "bold",
                            color: "#c00",
                            padding: "0",
                          },
                        },
                        "×"
                      ),

                      // Tên Danh mục
                      cat?.name || `ID ${catId}`
                    );
                  })
                ),

                // Dropdown thêm category mới
                createElement(SelectControl, {
                  label: "Thêm chuyên mục",
                  value: "__placeholder__",
                  options: [
                    { label: "Chọn danh mục", value: "__placeholder__" },
                    ...filteredCategories.map((cat) => ({
                      label: cat.name,
                      value: String(cat.id),
                    })),
                  ],
                  onChange: (newId) => {
                    if (newId === "__placeholder__") return;

                    const currentCats = attributes.selectedCategories || [];
                    if (!currentCats.includes(newId)) {
                      setAttributes({
                        selectedCategories: [...currentCats, newId],
                      });
                    }
                  },
                })
              ),

            // Select thêm Tag khi chọn nguồn là Tag
            attributes.sourceType === "tag" &&
              createElement(
                "div",
                { style: { marginTop: "10px" } },

                // Tag hiển thị Tag đã chọn
                createElement(
                  "div",
                  {
                    style: {
                      display: "flex",
                      flexWrap: "wrap",
                      gap: "6px",
                      marginBottom: "8px",
                    },
                  },
                  (attributes.selectedTags || []).map((tagId) => {
                    const tag = tags?.find(
                      (t) => String(t.id) === String(tagId)
                    );
                    // Tag đã chọn
                    return createElement(
                      "span",
                      {
                        key: tagId,
                        style: {
                          padding: "3px 8px",
                          background: "#eee",
                          borderRadius: "12px",
                          display: "flex",
                          alignItems: "center",
                          gap: "6px",
                        },
                      },

                      // Button xóa tag
                      createElement(
                        "button",
                        {
                          onClick: () =>
                            setAttributes({
                              selectedTags: attributes.selectedTags.filter(
                                (id) => id !== tagId
                              ),
                            }),
                          style: {
                            border: "none",
                            background: "transparent",
                            cursor: "pointer",
                            fontWeight: "bold",
                            color: "#c00", // ⭐ MÀU ĐỎ CHUẨN
                            padding: 0,
                            lineHeight: "1",
                          },
                        },
                        "×"
                      ),

                      // Tên Tag
                      tag?.name || `Tag ${tagId}`
                    );
                  })
                ),

                // Dropdown thêm tag mới
                createElement(Dropdown, {
                  className: "tag-select-dropdown",
                  // Button mở dropdown thêm tag
                  renderToggle: ({ onToggle }) =>
                    createElement(
                      "button",
                      {
                        onClick: onToggle,
                        className: "components-button is-secondary",
                        style: {
                          width: "100%",
                          textAlign: "left",
                          padding: "8px 10px",
                          borderRadius: "6px",
                          border: "1px solid #ccc",
                          marginBottom: "10px",
                        },
                      },
                      "Thêm tag"
                    ),
                  // Nội dung dropdown
                  renderContent: () =>
                    createElement(
                      "div",
                      { style: { padding: "10px", width: "350px" } },

                      /* Ô search tag */
                      createElement("input", {
                        type: "text",
                        placeholder: "Tìm tag...",
                        value: searchTag,
                        onChange: (e) => setSearchTag(e.target.value),
                        style: {
                          width: "100%",
                          padding: "8px",
                          marginBottom: "10px",
                          border: "1px solid #ccc",
                          borderRadius: "6px",
                        },
                      }),

                      /* Danh sách tag đã lọc bởi search */
                      createElement(
                        "div",
                        {
                          style: {
                            maxHeight: "300px",
                            overflowY: "auto",
                            border: "1px solid #ddd",
                            borderRadius: "6px",
                          },
                        },

                        filteredTagList.length === 0
                          ? createElement(
                              "div",
                              {
                                style: {
                                  padding: "10px",
                                  textAlign: "center",
                                  color: "#999",
                                },
                              },
                              "Không tìm thấy tag"
                            )
                          : filteredTagList.map((tag) =>
                              createElement(
                                "div",
                                {
                                  key: tag.id,
                                  onClick: () => {
                                    const current =
                                      attributes.selectedTags || [];
                                    if (!current.includes(String(tag.id))) {
                                      setAttributes({
                                        selectedTags: [
                                          ...current,
                                          String(tag.id),
                                        ],
                                      });
                                    }
                                  },
                                  style: {
                                    padding: "8px 10px",
                                    cursor: "pointer",
                                    borderBottom: "1px solid #eee",
                                  },
                                  onMouseEnter: (e) =>
                                    (e.target.style.background = "#f3f3f3"),
                                  onMouseLeave: (e) =>
                                    (e.target.style.background = "white"),
                                },
                                tag.name
                              )
                            )
                      )
                    ),
                })
              )
          ),
          // Số lượng bài viết
          layout === "slider" &&
            createElement(RangeControl, {
              label: "Số lượng bài viết",
              min: 1,
              max: 12,
              value: attributes.postsToShow,
              onChange: (v) => setAttributes({ postsToShow: v }),
            }),

          // Cách sắp xếp bài viết
          createElement(SelectControl, {
            label: "Cách sắp xếp bài viết",
            value: attributes.sortBy || "date_desc",
            options: [
              { label: "Mới nhất → Cũ nhất", value: "date_desc" },
              { label: "Cũ nhất → Mới nhất", value: "date_asc" },
              { label: "Lượt xem cao → thấp", value: "views_desc" },
              { label: "Lượt xem thấp → cao", value: "views_asc" },
              { label: "Tiêu đề A → Z", value: "title_asc" },
              { label: "Tiêu đề Z → A", value: "title_desc" },
            ],
            onChange: (v) => setAttributes({ sortBy: v }),
          }),

          // Bật tắt autoplay
          layout === "slider" &&
            createElement(ToggleControl, {
              label: "Tự chạy slider (autoplay)",
              checked: attributes.autoplay,
              onChange: (v) => setAttributes({ autoplay: v }),
            })
        ),

        // PANEL 2: Hiển thị thông tin
        createElement(
          //Hiển thị thông tin
          PanelBody,
          { title: "Hiển thị thông tin", initialOpen: false },
          createElement(ToggleControl, {
            label: "Hiện loại bài viết",
            checked: attributes.showCategory,
            onChange: (v) => setAttributes({ showCategory: v }),
          }),

          // Hiện ngày đăng
          createElement(ToggleControl, {
            label: "Hiện ngày đăng",
            checked: attributes.showDate,
            onChange: (v) => setAttributes({ showDate: v }),
          }),

          // Hiện lượt xem
          createElement(ToggleControl, {
            label: "Hiện lượt xem",
            checked: attributes.showViews,
            onChange: (v) => setAttributes({ showViews: v }),
          }),

          // Độ dài mô tả
          layout === "slider" &&
            createElement(RangeControl, {
              label: "Độ dài mô tả",
              min: 10,
              max: 50,
              value: attributes.excerptLength,
              onChange: (v) => setAttributes({ excerptLength: v }),
            }),

          // Ghim bài viết
          createElement(
            "h4",
            { style: { marginTop: "15px", marginBottom: "5px" } },
            "Ghim bài viết lên đầu"
          ),
          // Danh sách bài viết ghim
          createElement(
            "div",
            {
              className: "pinned-posts-wrapper",
              style: {
                display: "flex",
                flexWrap: "wrap",
                gap: "6px",
                marginBottom: "8px",
              },
            },

            (attributes.pinnedPosts || []).map((postId) => {
              const post = posts?.find((p) => p.id === postId);

              return createElement(
                "span",
                {
                  key: postId,
                  style: {
                    padding: "4px 12px 4px 20px",
                    background: "#f1f3f4",
                    border: "1px solid #d0d0d0",
                    borderRadius: "14px",
                    display: "inline-flex",
                    alignItems: "center",
                    position: "relative",
                    fontSize: "13px",
                  },
                },

                // Tiêu đề bài viết
                decodeHtml(post?.title?.rendered || `Bài #${postId}`),
                // Nút xóa
                createElement(
                  "button",
                  {
                    onClick: () =>
                      setAttributes({
                        pinnedPosts: attributes.pinnedPosts.filter(
                          (id) => id !== postId
                        ),
                      }),
                    style: {
                      position: "absolute",
                      left: "6px",
                      top: "50%",
                      transform: "translateY(-50%)",
                      border: "none",
                      background: "transparent",
                      cursor: "pointer",
                      fontSize: "13px",
                      padding: 0,
                      color: "#c00",
                      fontWeight: "bold",
                      lineHeight: "1",
                    },
                  },
                  "×"
                )
              );
            })
          ),
          /* Dropdown bài viết ghim */
          createElement(Dropdown, {
            className: "pinned-post-dropdown",

            renderToggle: ({ onToggle }) =>
              createElement(
                "button",
                {
                  onClick: onToggle,
                  className: "components-button is-secondary",
                  style: {
                    width: "100%",
                    textAlign: "left",
                    padding: "8px 10px",
                    borderRadius: "6px",
                    border: "1px solid #ccc",
                    margin: "8px 8px 8px 0px",
                  },
                },
                "Thêm bài ghim"
              ),

            renderContent: () =>
              createElement(
                "div",
                { style: { padding: "10px", width: "500px" } },

                /*Ô search bài ghim */
                createElement("input", {
                  type: "text",
                  placeholder: "Tìm bài viết...",
                  value: searchPinned,
                  onChange: (e) => setSearchPinned(e.target.value),
                  style: {
                    width: "100%",
                    padding: "8px",
                    marginBottom: "10px",
                    border: "1px solid #ccc",
                    borderRadius: "6px",
                  },
                }),

                /*Danh sách bài ghim đã lọc */
                createElement(
                  "div",
                  {
                    style: {
                      maxHeight: "500px",
                      overflowY: "auto",
                      border: "1px solid #ddd",
                      borderRadius: "6px",
                    },
                  },

                  filteredPosts.length === 0
                    ? createElement(
                        "div",
                        {
                          style: {
                            padding: "10px",
                            textAlign: "center",
                            color: "#999",
                          },
                        },
                        "Không tìm thấy bài viết"
                      )
                    : filteredPosts.map((p) =>
                        createElement(
                          "div",
                          {
                            key: p.id,
                            onClick: () => {
                              const selected = attributes.pinnedPosts || [];

                              if (!selected.includes(p.id)) {
                                setAttributes({
                                  pinnedPosts: [...selected, p.id],
                                });
                              }
                            },

                            style: {
                              padding: "8px 10px",
                              cursor: "pointer",
                              borderBottom: "1px solid #eee",
                            },
                            onMouseEnter: (e) =>
                              (e.target.style.background = "#f3f3f3"),
                            onMouseLeave: (e) =>
                              (e.target.style.background = "white"),
                          },

                          decodeHtml(p?.title?.rendered || `Bài #${p.id}`)
                        )
                      )
                )
              ),
          }),

          // Số dòng hiển thị tiêu đề (Grid 6)
          layout === "grid-6" &&
            attributes.limitTitleLinesGrid6 &&
            createElement(RangeControl, {
              label: "Số dòng hiển thị",
              min: 1,
              max: 4,
              value: attributes.titleLineClampGrid6,
              onChange: (v) => setAttributes({ titleLineClampGrid6: v }),
            }),
          // Giới hạn số dòng tiêu đề (Hero + Grid 3)
          layout === "hero-grid" &&
            createElement(ToggleControl, {
              label: "Giới hạn số dòng tiêu đề (card nhỏ)",
              checked: attributes.limitGridTitleLines,
              onChange: (v) => setAttributes({ limitGridTitleLines: v }),
            }),
          layout === "hero-grid" &&
            // Số dòng hiển thị tiêu đề (Hero + Grid 3)
            attributes.limitGridTitleLines &&
            createElement(RangeControl, {
              label: "Số dòng tiêu đề card nhỏ",
              min: 1,
              max: 4,
              value: attributes.gridTitleLineClamp,
              onChange: (v) => setAttributes({ gridTitleLineClamp: v }),
            })
        ),

        // PANEL 3: Tùy chỉnh giao diện Slider
        layout === "slider" &&
          createElement(
            PanelBody,
            { title: "Tùy chỉnh giao diện", initialOpen: false },
            // Nút reset toàn bộ giao diện slider về mặc định
            createElement(
              Button,
              {
                isPrimary: true,
                style: {
                  margin: "10px 0 18px 0",
                  padding: "6px 8px",
                  fontWeight: "600",
                  borderRadius: "4px",
                },
                onClick: () => {
                  setAttributes({
                    // Label
                    labelTextColor: "#ffffff",
                    labelBgColor: "#d33",
                    labelFontSize: 16,

                    // Category
                    catTextColor: "#ffffff",
                    catBgColor: "#d33",
                    catFontSize: 13,

                    // Title
                    titleColor: "#ffffff",
                    titleFontSize: 32,

                    // Excerpt
                    excerptColor: "#eeeeee",
                    excerptFontSize: 15,
                    // Font weight
                    labelFontWeight: "600",
                    catFontWeight: "600",
                    titleFontWeight: "700",
                    excerptFontWeight: "400",
                    sliderMetaWeight: "400",
                  });
                },
              },
              "Đặt lại mặc định"
            ),
            // Label
            createElement("h4", null, "Tiêu đề label"),
            //Màu chữ label
            createElement(ColorControlCompact, {
              label: "Màu chữ label",
              value: attributes.labelTextColor,
              onChange: (v) => setAttributes({ labelTextColor: v }),
            }),
            //Màu nền label
            createElement(ColorControlCompact, {
              label: "Màu nền label",
              value: attributes.labelBgColor,
              onChange: (v) => setAttributes({ labelBgColor: v }),
            }),
            //Cỡ chữ label
            createElement(RangeControl, {
              label: "Cỡ chữ label",
              min: 10,
              max: 40,
              value: attributes.labelFontSize,
              onChange: (v) => setAttributes({ labelFontSize: v }),
            }),
            // Độ đậm chữ label
            createElement(SelectControl, {
              label: "Độ đậm chữ label",
              value: attributes.labelFontWeight,
              options: FONT_WEIGHT_OPTIONS,
              onChange: (v) => setAttributes({ labelFontWeight: v }),
            }),

            createElement("hr", {
              style: {
                margin: "15px 0",
                border: 0,
                borderTop: "1px solid #ddd",
                opacity: 0.4,
              },
            }),
            // Category
            createElement("h4", null, "Nhãn chuyên mục"),
            // Màu chữ chuyên mục
            createElement(ColorControlCompact, {
              label: "Màu chữ chuyên mục",
              value: attributes.catTextColor,
              onChange: (v) => setAttributes({ catTextColor: v }),
            }),
            // Màu nền chuyên mục
            createElement(ColorControlCompact, {
              label: "Màu nền chuyên mục",
              value: attributes.catBgColor,
              onChange: (v) => setAttributes({ catBgColor: v }),
            }),
            // Cỡ chữ chuyên mục
            createElement(RangeControl, {
              label: "Cỡ chữ chuyên mục",
              min: 10,
              max: 30,
              value: attributes.catFontSize,
              onChange: (v) => setAttributes({ catFontSize: v }),
            }),
            // Độ đậm chữ chuyên mục
            createElement(SelectControl, {
              label: "Độ đậm chữ chuyên mục",
              value: attributes.catFontWeight,
              options: FONT_WEIGHT_OPTIONS,
              onChange: (v) => setAttributes({ catFontWeight: v }),
            }),
            createElement("hr", {
              style: {
                margin: "15px 0",
                border: 0,
                borderTop: "1px solid #ddd",
                opacity: 0.4,
              },
            }),
            // Title
            createElement("h4", null, "Tiêu đề bài viết"),
            createElement(ColorControlCompact, {
              label: "Màu tiêu đề",
              value: attributes.titleColor,
              onChange: (v) => setAttributes({ titleColor: v }),
            }),
            // Cỡ chữ tiêu đề
            createElement(RangeControl, {
              label: "Cỡ chữ tiêu đề",
              min: 16,
              max: 60,
              value: attributes.titleFontSize,
              onChange: (v) => setAttributes({ titleFontSize: v }),
            }),
            // Độ đậm chữ tiêu đề
            createElement(SelectControl, {
              label: "Độ đậm tiêu đề",
              value: attributes.titleFontWeight,
              options: FONT_WEIGHT_OPTIONS,
              onChange: (v) => setAttributes({ titleFontWeight: v }),
            }),

            createElement("hr", {
              style: {
                margin: "15px 0",
                border: 0,
                borderTop: "1px solid #ddd",
                opacity: 0.4,
              },
            }),
            // Excerpt
            createElement("h4", null, "Mô tả bài viết"),
            createElement(ColorControlCompact, {
              label: "Màu mô tả",
              value: attributes.excerptColor,
              onChange: (v) => setAttributes({ excerptColor: v }),
            }),
            // Cỡ chữ mô tả
            createElement(RangeControl, {
              label: "Cỡ chữ mô tả",
              min: 10,
              max: 30,
              value: attributes.excerptFontSize,
              onChange: (v) => setAttributes({ excerptFontSize: v }),
            }),
            // Độ đậm chữ mô tả
            createElement(SelectControl, {
              label: "Độ đậm mô tả",
              value: attributes.excerptFontWeight,
              options: FONT_WEIGHT_OPTIONS,
              onChange: (v) => setAttributes({ excerptFontWeight: v }),
            }),

            // Meta (ngày đăng + lượt xem)
            createElement(
              "h4",
              { style: { marginTop: "20px" } },
              "Ngày đăng & Lượt xem"
            ),
            // Màu meta
            createElement(ColorControlCompact, {
              label: "Màu meta",
              value: attributes.sliderMetaColor,
              onChange: (v) => setAttributes({ sliderMetaColor: v }),
            }),
            // Cỡ chữ meta
            createElement(RangeControl, {
              label: "Cỡ chữ meta",
              min: 10,
              max: 30,
              value: attributes.sliderMetaSize,
              onChange: (v) => setAttributes({ sliderMetaSize: v }),
            }),
            // Độ đậm chữ meta
            createElement(SelectControl, {
              label: "Độ đậm meta (ngày / lượt xem)",
              value: attributes.sliderMetaWeight,
              options: FONT_WEIGHT_OPTIONS,
              onChange: (v) => setAttributes({ sliderMetaWeight: v }),
            })
          ),
        // PANEL: Tùy chỉnh giao diện Grid 6
        layout === "grid-6" &&
          createElement(
            PanelBody,
            { title: "Tùy chỉnh giao diện", initialOpen: true },
            // Nút reset toàn bộ giao diện grid 6 về mặc định
            createElement(
              Button,
              {
                isPrimary: true,
                style: {
                  margin: "10px 0 18px",
                  padding: "6px 12px",
                  fontWeight: "600",
                  borderRadius: "4px",
                },
                onClick: () => {
                  setAttributes({
                    labelTextColor: "#ffffff",
                    labelBgColor: "#d33",
                    labelFontSize: 16,
                    labelFontWeightGrid6: "600",
                    catTextColorGrid6: "#ff6666",
                    catFontSizeGrid6: 17,
                    catFontWeightGrid6: "600",
                    metaTextColorGrid6: "#EDEDED",
                    metaFontSizeGrid6: 18,
                    metaFontWeightGrid6: "400",
                    titleTextColorGrid6: "#5d5c5c",
                    titleFontSizeGrid6: 18,
                    titleFontWeightGrid6: "600",
                    cardBgGrid6: "#302D2D54",
                  });
                },
              },
              "Đặt lại mặc định"
            ),

            //Màu chữ label
            createElement(ColorControlCompact, {
              label: "Màu chữ label",
              value: attributes.labelTextColor,
              onChange: (v) => setAttributes({ labelTextColor: v }),
            }),

            //Màu nền label
            createElement(ColorControlCompact, {
              label: "Màu nền label",
              value: attributes.labelBgColor,
              onChange: (v) => setAttributes({ labelBgColor: v }),
            }),

            //Cỡ chữ label
            createElement(RangeControl, {
              label: "Cỡ chữ label",
              min: 10,
              max: 40,
              value: attributes.labelFontSize,
              onChange: (v) => setAttributes({ labelFontSize: v }),
            }),

            // Độ đậm chữ label
            createElement(SelectControl, {
              label: "Độ đậm chữ label",
              value: attributes.labelFontWeightGrid6,
              options: FONT_WEIGHT_OPTIONS,
              onChange: (v) => setAttributes({ labelFontWeightGrid6: v }),
            }),

            createElement("hr", {
              style: {
                margin: "16px 0",
                border: 0,
                borderTop: "1px solid #ddd",
                opacity: 0.4,
              },
            }),

            createElement("h4", null, "Danh mục (Category)"),

            // Màu chữ chuyên mục
            createElement(ColorControlCompact, {
              label: "Màu chữ chuyên mục",
              value: attributes.catTextColorGrid6,
              onChange: (v) => setAttributes({ catTextColorGrid6: v }),
            }),

            // Cỡ chữ chuyên mục
            createElement(RangeControl, {
              label: "Cỡ chữ chuyên mục",
              min: 10,
              max: 30,
              value: attributes.catFontSizeGrid6,
              onChange: (v) => setAttributes({ catFontSizeGrid6: v }),
            }),

            //Độ đậm chữ chuyên mục
            createElement(SelectControl, {
              label: "Độ đậm chữ chuyên mục",
              value: attributes.catFontWeightGrid6,
              options: FONT_WEIGHT_OPTIONS,
              onChange: (v) => setAttributes({ catFontWeightGrid6: v }),
            }),

            createElement("hr", {
              style: {
                margin: "16px 0",
                border: 0,
                borderTop: "1px solid #ddd",
                opacity: 0.4,
              },
            }),

            createElement("h4", null, "Ngày tháng & lượt xem"),

            // Màu chữ meta
            createElement(ColorControlCompact, {
              label: "Màu chữ meta",
              value: attributes.metaTextColorGrid6,
              onChange: (v) => setAttributes({ metaTextColorGrid6: v }),
            }),

            // Cỡ chữ meta
            createElement(RangeControl, {
              label: "Cỡ chữ meta",
              min: 10,
              max: 30,
              value: attributes.metaFontSizeGrid6,
              onChange: (v) => setAttributes({ metaFontSizeGrid6: v }),
            }),

            // Độ đậm chữ meta
            createElement(SelectControl, {
              label: "Độ đậm chữ meta",
              value: attributes.metaFontWeightGrid6,
              options: FONT_WEIGHT_OPTIONS,
              onChange: (v) => setAttributes({ metaFontWeightGrid6: v }),
            }),

            createElement("hr", {
              style: {
                margin: "16px 0",
                border: 0,
                borderTop: "1px solid #ddd",
                opacity: 0.4,
              },
            }),

            createElement("h4", null, "Tiêu đề bài viết"),

            // Màu chữ tiêu đề
            createElement(ColorControlCompact, {
              label: "Màu chữ tiêu đề",
              value: attributes.titleTextColorGrid6,
              onChange: (v) => setAttributes({ titleTextColorGrid6: v }),
            }),

            // Cỡ chữ tiêu đề
            createElement(RangeControl, {
              label: "Cỡ chữ tiêu đề",
              min: 12,
              max: 40,
              value: attributes.titleFontSizeGrid6,
              onChange: (v) => setAttributes({ titleFontSizeGrid6: v }),
            }),

            // Độ đậm chữ tiêu đề
            createElement(SelectControl, {
              label: "Độ đậm tiêu đề",
              value: attributes.titleFontWeightGrid6,
              options: FONT_WEIGHT_OPTIONS,
              onChange: (v) => setAttributes({ titleFontWeightGrid6: v }),
            }),

            createElement("hr", {
              style: {
                margin: "16px 0",
                border: 0,
                borderTop: "1px solid #ddd",
                opacity: 0.4,
              },
            }),

            createElement("h4", null, "Nền Card"),

            // Màu nền card
            createElement(ColorControlCompact, {
              label: "Màu nền card",
              value: attributes.cardBgGrid6,
              onChange: (v) => setAttributes({ cardBgGrid6: v }),
            })
          ),
        //  PANEL: Tùy chỉnh Hero + Grid 3
        layout === "hero-grid" &&
          createElement(
            PanelBody,
            { title: "Tùy chỉnh giao diện", initialOpen: true },

            // Nút reset toàn bộ giao diện hero + grid 3 về mặc định
            createElement(
              Button,
              {
                isPrimary: true,
                style: {
                  margin: "10px 0 18px",
                  padding: "6px 12px",
                  fontWeight: "600",
                },
                onClick: () => {
                  setAttributes({
                    labelTextColor: "#ffffff",
                    labelBgColor: "#d33",
                    labelFontSize: 16,
                    labelFontWeight: "600",
                    heroCatColor: "#ff5d5d",
                    heroCatSize: 34,
                    heroCatWeight: "600",
                    heroTitleColor: "#f3f3f3",
                    heroTitleSize: 28,
                    heroTitleWeight: "700",
                    heroMetaColor: "#adadad",
                    heroMetaSize: 18,
                    heroMetaWeight: "400",
                    heroGridCatColor: "#ff6666",
                    heroGridCatSize: 17,
                    heroGridCatWeight: "600",
                    heroGridTitleColor: "#5d5c5c",
                    heroGridTitleSize: 18,
                    heroGridTitleWeight: "600",
                    heroGridMetaColor: "#EDEDED",
                    heroGridMetaSize: 16,
                    heroGridMetaWeight: "400",
                    heroGridCardBg: "#302D2D54",
                  });
                },
              },
              "Đặt lại mặc định"
            ),

            createElement("h4", null, "Label"),

            // Màu chữ label
            createElement(ColorControlCompact, {
              label: "Màu chữ label",
              value: attributes.labelTextColor,
              onChange: (v) => setAttributes({ labelTextColor: v }),
            }),

            // Màu nền label
            createElement(ColorControlCompact, {
              label: "Màu nền label",
              value: attributes.labelBgColor,
              onChange: (v) => setAttributes({ labelBgColor: v }),
            }),

            // Cỡ chữ label
            createElement(RangeControl, {
              label: "Cỡ chữ label",
              min: 10,
              max: 40,
              value: attributes.labelFontSize,
              onChange: (v) => setAttributes({ labelFontSize: v }),
            }),

            // Độ đậm label
            createElement(SelectControl, {
              label: "Độ đậm chữ label",
              value: attributes.labelFontWeight,
              options: FONT_WEIGHT_OPTIONS,
              onChange: (v) => setAttributes({ labelFontWeight: v }),
            }),

            createElement("hr"),

            createElement("h4", null, "Hero chính"),

            //Màu category HERO
            createElement(ColorControlCompact, {
              label: "Màu category HERO",
              value: attributes.heroCatColor,
              onChange: (v) => setAttributes({ heroCatColor: v }),
            }),

            //Cỡ chữ category HERO
            createElement(RangeControl, {
              label: "Cỡ chữ category HERO",
              min: 10,
              max: 60,
              value: attributes.heroCatSize,
              onChange: (v) => setAttributes({ heroCatSize: v }),
            }),

            // Độ đậm category HERO
            createElement(SelectControl, {
              label: "Độ đậm category HERO",
              value: attributes.heroCatWeight,
              options: FONT_WEIGHT_OPTIONS,
              onChange: (v) => setAttributes({ heroCatWeight: v }),
            }),

            //Màu tiêu đề HERO
            createElement(ColorControlCompact, {
              label: "Màu tiêu đề HERO",
              value: attributes.heroTitleColor,
              onChange: (v) => setAttributes({ heroTitleColor: v }),
            }),

            //Cỡ chữ tiêu đề HERO
            createElement(RangeControl, {
              label: "Cỡ chữ tiêu đề HERO",
              min: 16,
              max: 60,
              value: attributes.heroTitleSize,
              onChange: (v) => setAttributes({ heroTitleSize: v }),
            }),

            // Độ đậm tiêu đề HERO
            createElement(SelectControl, {
              label: "Độ đậm tiêu đề HERO",
              value: attributes.heroTitleWeight,
              options: FONT_WEIGHT_OPTIONS,
              onChange: (v) => setAttributes({ heroTitleWeight: v }),
            }),

            createElement("h4", null, "Meta HERO (Ngày + View)"),

            // Màu meta HERO
            createElement(ColorControlCompact, {
              label: "Màu meta HERO",
              value: attributes.heroMetaColor,
              onChange: (v) => setAttributes({ heroMetaColor: v }),
            }),

            // Cỡ chữ meta HERO
            createElement(RangeControl, {
              label: "Cỡ chữ meta HERO",
              min: 10,
              max: 40,
              value: attributes.heroMetaSize,
              onChange: (v) => setAttributes({ heroMetaSize: v }),
            }),

            // Độ đậm meta HERO
            createElement(SelectControl, {
              label: "Độ đậm meta HERO",
              value: attributes.heroMetaWeight,
              options: FONT_WEIGHT_OPTIONS,
              onChange: (v) => setAttributes({ heroMetaWeight: v }),
            }),

            createElement("hr"),

            createElement("h4", null, "Grid 3 bài"),

            //Màu category grid
            createElement(ColorControlCompact, {
              label: "Màu category grid",
              value: attributes.heroGridCatColor,
              onChange: (v) => setAttributes({ heroGridCatColor: v }),
            }),

            //Cỡ chữ category grid
            createElement(RangeControl, {
              label: "Cỡ chữ category grid",
              min: 10,
              max: 30,
              value: attributes.heroGridCatSize,
              onChange: (v) => setAttributes({ heroGridCatSize: v }),
            }),

            // Độ đậm category grid
            createElement(SelectControl, {
              label: "Độ đậm category grid",
              value: attributes.heroGridCatWeight,
              options: FONT_WEIGHT_OPTIONS,
              onChange: (v) => setAttributes({ heroGridCatWeight: v }),
            }),

            //Màu tiêu đề grid
            createElement(ColorControlCompact, {
              label: "Màu tiêu đề grid",
              value: attributes.heroGridTitleColor,
              onChange: (v) => setAttributes({ heroGridTitleColor: v }),
            }),

            //Cỡ chữ tiêu đề grid
            createElement(RangeControl, {
              label: "Cỡ chữ tiêu đề grid",
              min: 12,
              max: 40,
              value: attributes.heroGridTitleSize,
              onChange: (v) => setAttributes({ heroGridTitleSize: v }),
            }),

            // Độ đậm tiêu đề grid
            createElement(SelectControl, {
              label: "Độ đậm tiêu đề grid",
              value: attributes.heroGridTitleWeight,
              options: FONT_WEIGHT_OPTIONS,
              onChange: (v) => setAttributes({ heroGridTitleWeight: v }),
            }),

            //Màu meta grid
            createElement(ColorControlCompact, {
              label: "Màu meta grid",
              value: attributes.heroGridMetaColor,
              onChange: (v) => setAttributes({ heroGridMetaColor: v }),
            }),

            //Cỡ chữ meta grid
            createElement(RangeControl, {
              label: "Cỡ chữ meta grid",
              min: 10,
              max: 30,
              value: attributes.heroGridMetaSize,
              onChange: (v) => setAttributes({ heroGridMetaSize: v }),
            }),

            // Độ đậm meta grid
            createElement(SelectControl, {
              label: "Độ đậm meta grid",
              value: attributes.heroGridMetaWeight,
              options: FONT_WEIGHT_OPTIONS,
              onChange: (v) => setAttributes({ heroGridMetaWeight: v }),
            }),

            //Màu nền card grid
            createElement(ColorControlCompact, {
              label: "Màu nền card grid",
              value: attributes.heroGridCardBg,
              onChange: (v) => setAttributes({ heroGridCardBg: v }),
            })
          ),

        //PANEL: Tùy chỉnh layout Magazine Hero
        layout === "magazine-hero" &&
          createElement(
            PanelBody,
            { title: "Tùy chỉnh giao diện", initialOpen: true },
            // Nút reset toàn bộ giao diện magazine hero về mặc định
            createElement(
              Button,
              {
                isPrimary: true,
                style: {
                  margin: "10px 0 18px",
                  padding: "6px 12px",
                  fontWeight: "600",
                  borderRadius: "4px",
                },
                onClick: () => {
                  setAttributes({
                    labelTextColor: "#ffffff",
                    labelBgColor: "#d33",
                    labelFontSize: 16,
                    labelFontWeight: "600",

                    heroCatColor: "#ff5d5d",
                    heroCatSize: 34,
                    heroCatWeight: "600",

                    heroTitleColor: "#f3f3f3",
                    heroTitleSize: 28,
                    heroTitleWeight: "700",

                    heroMetaColor: "#adadad",
                    heroMetaSize: 18,
                    heroMetaWeight: "400",

                    heroGridCatColor: "#ff6666",
                    heroGridCatSize: 17,
                    heroGridCatWeight: "600",

                    heroGridTitleColor: "#ffffff",
                    heroGridTitleSize: 18,
                    heroGridTitleWeight: "600",

                    heroGridMetaColor: "#adadad",
                    heroGridMetaSize: 18,
                    heroGridMetaWeight: "400",

                    heroGridCardBg: "rgba(49,45,45,0.06)",
                  });
                },
              },
              "Đặt lại mặc định"
            ),

            createElement("h4", null, "Label"),

            // Màu chữ label
            createElement(ColorControlCompact, {
              label: "Màu chữ label",
              value: attributes.labelTextColor,
              onChange: (v) => setAttributes({ labelTextColor: v }),
            }),

            // Màu nền label
            createElement(ColorControlCompact, {
              label: "Màu nền label",
              value: attributes.labelBgColor,
              onChange: (v) => setAttributes({ labelBgColor: v }),
            }),

            // Cỡ chữ label
            createElement(RangeControl, {
              label: "Cỡ chữ label",
              min: 10,
              max: 40,
              value: attributes.labelFontSize,
              onChange: (v) => setAttributes({ labelFontSize: v }),
            }),

            // Độ đậm chữ label
            createElement(SelectControl, {
              label: "Độ đậm chữ label",
              value: attributes.labelFontWeight,
              options: FONT_WEIGHT_OPTIONS,
              onChange: (v) => setAttributes({ labelFontWeight: v }),
            }),

            createElement("hr", { style: { margin: "15px 0" } }),

            createElement("h4", null, "Card 1 Hero"),

            // Màu category HERO
            createElement(ColorControlCompact, {
              label: "Màu category Hero",
              value: attributes.heroCatColor,
              onChange: (v) => setAttributes({ heroCatColor: v }),
            }),

            // Cỡ chữ category HERO
            createElement(RangeControl, {
              label: "Cỡ chữ category Hero",
              min: 10,
              max: 60,
              value: attributes.heroCatSize,
              onChange: (v) => setAttributes({ heroCatSize: v }),
            }),

            //Độ đậm category HERO
            createElement(SelectControl, {
              label: "Độ đậm category Hero",
              value: attributes.heroCatWeight,
              options: FONT_WEIGHT_OPTIONS,
              onChange: (v) => setAttributes({ heroCatWeight: v }),
            }),

            // Màu tiêu đề HERO
            createElement(ColorControlCompact, {
              label: "Màu tiêu đề Hero",
              value: attributes.heroTitleColor,
              onChange: (v) => setAttributes({ heroTitleColor: v }),
            }),

            // Cỡ chữ tiêu đề HERO
            createElement(RangeControl, {
              label: "Cỡ chữ tiêu đề Hero",
              min: 16,
              max: 60,
              value: attributes.heroTitleSize,
              onChange: (v) => setAttributes({ heroTitleSize: v }),
            }),

            // Độ đậm tiêu đề HERO
            createElement(SelectControl, {
              label: "Độ đậm tiêu đề Hero",
              value: attributes.heroTitleWeight,
              options: FONT_WEIGHT_OPTIONS,
              onChange: (v) => setAttributes({ heroTitleWeight: v }),
            }),

            // Màu meta HERO
            createElement(ColorControlCompact, {
              label: "Màu meta Hero",
              value: attributes.heroMetaColor,
              onChange: (v) => setAttributes({ heroMetaColor: v }),
            }),

            // Cỡ chữ meta HERO
            createElement(RangeControl, {
              label: "Cỡ chữ meta Hero",
              min: 10,
              max: 40,
              value: attributes.heroMetaSize,
              onChange: (v) => setAttributes({ heroMetaSize: v }),
            }),

            // Độ đậm meta HERO
            createElement(SelectControl, {
              label: "Độ đậm meta Hero",
              value: attributes.heroMetaWeight,
              options: FONT_WEIGHT_OPTIONS,
              onChange: (v) => setAttributes({ heroMetaWeight: v }),
            }),

            createElement("hr", { style: { margin: "15px 0" } }),

            createElement("h4", null, "Card 2, 3, 4"),

            // Màu category card nhỏ
            createElement(ColorControlCompact, {
              label: "Màu category card nhỏ",
              value: attributes.heroGridCatColor,
              onChange: (v) => setAttributes({ heroGridCatColor: v }),
            }),

            // Cỡ chữ category card nhỏ
            createElement(RangeControl, {
              label: "Cỡ chữ category card nhỏ",
              min: 10,
              max: 30,
              value: attributes.heroGridCatSize,
              onChange: (v) => setAttributes({ heroGridCatSize: v }),
            }),

            // Độ đậm chữ category card nhỏ
            createElement(SelectControl, {
              label: "Độ đậm category card nhỏ",
              value: attributes.heroGridCatWeight,
              options: FONT_WEIGHT_OPTIONS,
              onChange: (v) => setAttributes({ heroGridCatWeight: v }),
            }),

            // Màu tiêu đề card nhỏ
            createElement(ColorControlCompact, {
              label: "Màu tiêu đề card nhỏ",
              value: attributes.heroGridTitleColor,
              onChange: (v) => setAttributes({ heroGridTitleColor: v }),
            }),

            // Cỡ chữ tiêu đề card nhỏ
            createElement(RangeControl, {
              label: "Cỡ chữ tiêu đề card nhỏ",
              min: 10,
              max: 40,
              value: attributes.heroGridTitleSize,
              onChange: (v) => setAttributes({ heroGridTitleSize: v }),
            }),

            // Độ đậm chữ tiêu đề card nhỏ
            createElement(SelectControl, {
              label: "Độ đậm tiêu đề card nhỏ",
              value: attributes.heroGridTitleWeight,
              options: FONT_WEIGHT_OPTIONS,
              onChange: (v) => setAttributes({ heroGridTitleWeight: v }),
            }),

            // Màu meta card nhỏ
            createElement(ColorControlCompact, {
              label: "Màu meta card nhỏ",
              value: attributes.heroGridMetaColor,
              onChange: (v) => setAttributes({ heroGridMetaColor: v }),
            }),

            // Cỡ chữ meta card nhỏ
            createElement(RangeControl, {
              label: "Cỡ chữ meta card nhỏ",
              min: 10,
              max: 40,
              value: attributes.heroGridMetaSize,
              onChange: (v) => setAttributes({ heroGridMetaSize: v }),
            }),

            // Độ đậm chữ meta card nhỏ
            createElement(SelectControl, {
              label: "Độ đậm meta card nhỏ",
              value: attributes.heroGridMetaWeight,
              options: FONT_WEIGHT_OPTIONS,
              onChange: (v) => setAttributes({ heroGridMetaWeight: v }),
            })
          )
      ),
      createElement(
        "div",
        {
          className: "hero-featured-editor-preview",
          style: {
            padding: "20px",
            background: "#f5f5f5",
            height: "100%",
          },
        },
        createElement(ServerSideRender, {
          block: "admiral/hero-featured",
          attributes: attributes,
        })
      )
    );
  },

  save: () => null,
});
