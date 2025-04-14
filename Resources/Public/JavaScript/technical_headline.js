class TechnicalHeadline {
  constructor() {
    this.init()

    document.addEventListener("page:enter", () => {
      this.init()
    })
  }

  init() {
    if (this.cacheDom()) {
      this.generateTableOfContents()
    }
  }

  cacheDom() {
    const technicalHeadlineElement = document.querySelectorAll(
      ".technical-headline"
    )
    const firstElement = technicalHeadlineElement[0]

    if (!technicalHeadlineElement.length || !firstElement) {
      return false
    }

    this.firstEl = firstElement
    this.technicalHeadlineEl = technicalHeadlineElement

    return true
  }

  generateTableOfContents() {
    if (document.querySelector("#technical-headline-toc")) {
      return
    }

    let html = `
      <div id="technical-headline-toc" class="technical-headline-toc">
        <h2 class="technical-headline-toc__headline">Table of contents</h2>
        <ul class="technical-headline-toc__items">
    `

    this.technicalHeadlineEl.forEach(headlineEl => {
      const title = headlineEl.querySelector(".technical-headline__title")
        ?.innerHTML
      html += `<li class="technical-headline-toc__item"><a class="technical-headline-toc__link" href="#${headlineEl.getAttribute(
        "id"
      )}">${title}</a></li>`
    })
    html += "</ul></div>"

    this.firstEl?.insertAdjacentHTML("beforebegin", html)
  }
}

new TechnicalHeadline()
