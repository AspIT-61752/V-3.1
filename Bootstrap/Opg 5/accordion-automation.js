window.addEventListener("DOMContentLoaded", () => {
  const template = document.querySelector("#accordionTemplate");
  const container = document.querySelector("#accordionContainer");

  const content = template.content.cloneNode(true);
  const children = Array.from(content.children);

  let accordionIndex = 0;
  let currentGroup = [];
  let currentTitle = "";

  const createAccordionItem = (index, title, bodyElements) => {
    const headingId = `heading${index}`;
    const collapseId = `collapse${index}`;

    const item = document.createElement("div");
    item.className = "accordion-item";

    item.innerHTML = `
        <h2 class="accordion-header" id="${headingId}">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#${collapseId}" aria-expanded="false" aria-controls="${collapseId}">
            ${title}
          </button>
        </h2>
        <div id="${collapseId}" class="accordion-collapse collapse" aria-labelledby="${headingId}">
          <div class="accordion-body"></div>
        </div>
      `;

    const body = item.querySelector(".accordion-body");
    bodyElements.forEach((el) => body.appendChild(el));

    return item;
  };

  for (const el of children) {
    if (el.tagName === "H2") {
      if (currentGroup.length > 0) {
        const accordionItem = createAccordionItem(
          accordionIndex++,
          currentTitle,
          currentGroup
        );
        container.appendChild(accordionItem);
      }
      currentTitle = el.textContent;
      currentGroup = [];
    } else {
      currentGroup.push(el);
    }
  }

  if (currentGroup.length > 0) {
    const accordionItem = createAccordionItem(
      accordionIndex++,
      currentTitle,
      currentGroup
    );
    container.appendChild(accordionItem);
  }
});
