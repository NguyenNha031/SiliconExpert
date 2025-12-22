wp.blocks.registerBlockType("admiral/wp-card", {
  edit(props) {
    const { attributes, setAttributes } = props;

    return wp.element.createElement(
      "div",
      { className: "wp-card-editor" },
      wp.element.createElement("input", {
        type: "text",
        value: attributes.title,
        placeholder: "Enter title...",
        onChange: (e) => setAttributes({ title: e.target.value }),
      }),
      wp.element.createElement("textarea", {
        value: attributes.desc,
        placeholder: "Enter description...",
        onChange: (e) => setAttributes({ desc: e.target.value }),
      }),
      wp.element.createElement("input", {
        type: "text",
        value: attributes.image,
        placeholder: "Enter image URL...",
        onChange: (e) => setAttributes({ image: e.target.value }),
      })
    );
  },
  save() {
    return null; // Render bằng PHP
  },
});
