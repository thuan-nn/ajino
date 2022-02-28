$(document).on('ready', function () {
  // Menu link element HTML
  let header = $('#header'),
    headerLang = $('.header__lang'),
    headerLangList = $('.header__lang-list'),
    headerLangCurrent = $('.header__lang-current'),
    headerSearch = $('.header__search'),
    headerMenu = $('.header__menu'),
    headerSubMenu = $('.header__submenu'),
    headerSubMenuWrap = $('.header__submenu-wrap'),
    headerSubMenuBlock = $('.header__submenu-block'),
    menu_Link = $('.header__menu-link ,.header__info-link'),
    subMenuLink_First = $('.header__submenu-link'),
    subMenuLink_Second = $('.header__submenu .header__submenu .header__submenu-link'),
    subMenuLink_Third = $('.header__submenu .header__submenu .header__submenu .header__submenu-link')
  // Slide top element HTML
  let slideTop = $('.slide-top'),
    iframe = slideTop.find('iframe')
  // Handler event menu link header
  let jsMenuMobile = $('.js-menu'),
    jsSubMenu = $('.js-submenu'),
    jsAccordionMenu = $('.js-accordion'),
    jsCloseMenu = $('.js-close'),
    jsCloseSubMenu = $('.js-submenu-close'),
    jsBackMenuPrev = $('.js-back')
  // Handler event menu link footer
  let jsFooter = $('.js-footer')
  // Handler upload file
  const MAX_FILE_SIZE = 5 * 1024 * 1024 // Limit 1 file 5MB.
  let filesUploadData = []
  let formContact = $('#form-contact'),
    formRecruitment = $('#form-recruitment'),
    formCareerSearch = $('#form-career'),

    formFileUpload = $('.form-file-upload'),
    fileNameHTML = $('.file-name'),
    fileListHTML = $('.file-list'),
    inputField = $('.form-control'),
    inputFileUpload = $('#file-upload'),
    inputResetForm = $('input[type="reset"]')
  // Element HTML calendar company tour
  let calendar, dataCompanyTour,
    dataUserRegisterCompanyTour = {},
    locationCompanySelect = $('.company-register__select select'),
    calendarEl = document.getElementById('calendar'),
    defaultLocationFirstID = locationCompanySelect.find('option[selected]'),
    popupRegisterCompanyTour = $('.popup__register'),
    popupHome = $('.popup__home'),
    popupSuccess = $('.popup__success'),
    popupMap = $('.popup__map'),
    formRegisterCompanyTour = $('#register-company-tour'),
    languageHTML = $('html').attr('lang'),
    contentRegisterCompanyTour = $('.company-register__content'),
    nameFactory = $('.company__content-name'),
    linkFacebook = $('.company__content-facebook'),
    linkMapLocationFactory = $('.company-register__map')
  // Error element HTML
  let errorCaptchaElement = $('.error__msg'),
    errorInputElement = $('.notify-errors')
  let formatMonthFullCalendar = (languageHTML === 'vi') ? '2-digit' : 'long'
  // Get ID factory
  let idFactoryCompanyTour = (window.location.href.includes('id')) ? window.location.href.split('?id=')[1] : ''
  // Element Table
  let hasTable = $('.container table')

  let bannerAdvertise = $('.banner-advertise'),
    bannerAdvertiseBtn = $('.banner-advertise__btn'),
    bannerAdvertiseSmall = $('.banner-advertise-small'),

    bannerAdvertiseMobile = $('.banner-advertise-mobile'),
    bannerAdvertiseMobileBtn = $('.banner-advertise-mobile__btn')

  // Show - hidden lang header
  headerLang.on('click', function () {
    headerLangList.stop(true, true).slideToggle('fast')
    headerLangCurrent.toggleClass('is-active')
  })
  headerLang.on('mouseleave', function () {
    headerLangList.css('display', 'none')
    headerLangCurrent.removeClass('is-active')
  })

  // Show form search header
  $('.js-search').on('click', function (e) {
    e.preventDefault()
    let inputField = headerSearch.find('input')

    $(this).toggleClass('is-active')
    headerSearch.toggleClass('is-active')
    headerSearch.stop(true, true).slideToggle('fast')
    inputField.focus().prop('tabIndex', !1)
  })

  // Close form search header
  $('.js-search-close').on('click', function (e) {
    e.preventDefault()

    let headerSearchIsActive = $(this).closest('.header__search')

    if (headerSearchIsActive.hasClass('is-active')) {
      headerSearchIsActive.toggle()
      headerSearchIsActive.removeClass('is-active')
      $('.js-search').removeClass('is-active')
    }
  })

  // Show submenu on the navigation
  jsAccordionMenu.each(function () {
    $(this).on('click', function (e) {
      e.preventDefault()
      jsAccordionMenu.not(this).removeClass('is-active')
      // remove all children activated
      $(this).siblings('.header__submenu').find('ul > li > a').removeClass('is-active')

      headerSubMenu.removeAttr('style')
      $(this).toggleClass('is-active')

      if ($(this).hasClass('is-active')) {
        $(this).siblings('.header__submenu').slideDown()
      }

      if ($(window).innerWidth() < 1024) {
        jsBackMenuPrev.addClass('is-active')
      }
      jsCloseSubMenu.addClass('is-active')
    })
  })

  // Show submenu level 2 on the navigation
  jsSubMenu.on('click', function (e) {
    e.preventDefault()
    let el = $(e.currentTarget)
    el.parent().siblings().children().removeClass('is-active')
    el.toggleClass('is-active')
    headerSubMenuBlock.css('height', '')

    const children = el.closest('.header__menu-item').find('.header__submenu')

    const maxHeightSubmenu = Math.max.apply(null, children.map(function (i) {
      return $(this).outerHeight()
    }).get())

    let paddingTop = headerSubMenuWrap.css('padding-top')
    let paddingBottom = headerSubMenuWrap.css('padding-bottom')
    headerSubMenuBlock.css('height', maxHeightSubmenu + (parseInt(paddingTop) + parseInt(paddingBottom)))

    if (el.hasClass('is-active') && $(window).innerWidth() < 1024) {
      jsBackMenuPrev.addClass('is-active')
    }
  })

  // Close submenu level 2 on the navigation
  jsCloseSubMenu.on('click', function (e) {
    e.preventDefault()
    if ($(this).hasClass('is-active')) {
      $(this).removeClass('is-active')
      if (jsAccordionMenu.hasClass('is-active')) {
        $('.header__submenu').slideUp()
      }
    }
    header.find('.is-active').removeClass('is-active')
  })

  // Open navigation mobile
  jsMenuMobile.on('click', function (e) {
    e.preventDefault()
    header.addClass('is-active')
    jsCloseMenu.addClass('is-active')
  })

  // Close navigation mobile
  jsCloseMenu.on('click', function (e) {
    e.preventDefault()
    if (header.hasClass('is-active')) {
      header.removeClass('is-active')
    }
    headerMenu.find('.is-active').removeClass('is-active')
    headerSubMenu.removeAttr('style')
  })

  // Back menu previous
  jsBackMenuPrev.on('click', function (e) {
    e.preventDefault()
    if (subMenuLink_Third.hasClass('is-active')) {
      subMenuLink_Third.removeClass('is-active')

    } else if (subMenuLink_Second.hasClass('is-active')) {
      subMenuLink_Second.removeClass('is-active')

    } else if (subMenuLink_First.hasClass('is-active')) {
      subMenuLink_First.removeClass('is-active')

    } else if (menu_Link.hasClass('is-active')) {
      $(this).removeClass('is-active')
      menu_Link.removeClass('is-active')
      headerSubMenu.removeAttr('style')
    }
  })

  // Resize window header & footer
  $(window).on('resize', function () {
    $('body').addClass('is-stop-transition')
    setTimeout(() => {
      $('body').removeClass('is-stop-transition')
    }, 100)

    if ($(this).innerWidth() < 1024) {
      if (jsAccordionMenu.hasClass('is-active') || jsSubMenu.hasClass('is-active')) {
        jsBackMenuPrev.addClass('is-active')

        if (!header.hasClass('is-active')) {
          header.addClass('is-active')
        }
      }
    } else {
      jsAccordionMenu.each(function (index) {
        if ($(this).hasClass('is-active')) {
          $(this).siblings('.header__submenu').slideDown()
        } else {
          $(this).siblings('.header__submenu').slideUp()
        }
      })

      jsBackMenuPrev.removeClass('is-active')
    }

    if ($(this).innerWidth() > 1024) {
      jsFooter.removeClass('is-active')
      jsFooter.closest('.footer__menu').find('.footer__submenu').removeAttr('style')
    }

    if (bannerAdvertiseSmall.hasClass('show')) {
      if (window.innerWidth === 768 || window.innerWidth === 1024) {
        bannerAdvertiseSmall.removeClass('show')
      }
    } else {
      if (!popupHome.hasClass('show')) {
        if (window.matchMedia('(max-width: 767px)').matches) {
          bannerAdvertiseMobile.addClass('show')
          bannerAdvertise.removeClass('show')
        } else {
          bannerAdvertiseMobile.removeClass('show')
          bannerAdvertise.addClass('show')
        }
      }
    }
  })

  // Scroll menu header
  $(window).on('scroll', function () {
    if ($(window).scrollTop() > header.height()) {
      header.addClass('header-fixed')
    } else {
      header.removeClass('header-fixed')
    }
  })

  // Banner advertise
  bannerAdvertiseBtn.on('click', function (e) {
    bannerAdvertiseSmall.addClass('show')
    bannerAdvertise.removeClass('show')
    e.preventDefault()
  })

  bannerAdvertiseSmall.on('click', function () {
    bannerAdvertiseSmall.removeClass('show')

    if ((window.matchMedia('(max-width: 767px)').matches)) {
      bannerAdvertiseMobile.addClass('show')
    } else {
      bannerAdvertise.addClass('show')
    }
  })

  bannerAdvertiseMobileBtn.on('click', function (e) {
    bannerAdvertiseMobile.removeClass('show')
    bannerAdvertiseSmall.addClass('show')
    e.preventDefault()
  })

  // Menu footer accordion
  jsFooter.on('click', function (e) {
    e.preventDefault()
    if ($(window).width() < 1024) {
      $(this).toggleClass('is-active')
      if ($(this).hasClass('is-active')) {
        $(this).next().slideDown()
      } else {
        $(this).next().slideUp()
      }
    } else {
      $(this).removeClass('is-active')
    }
  })
  // Reset form career search
  if (formCareerSearch.length > 0) {
    formCareerSearch[0].reset()
  }
  // Handle event click step career recruitment
  $('.career-recruit__step li').on('click', function (event) {
    event.preventDefault()
    $('li').removeClass('active')
    $(this).addClass('active')
  })

  // Show popup and close popup from event click & type esc keyboard
  $('.show-map-company').on('click', function (event) {
    event.preventDefault()
    $(this).closest('.item').next().addClass('show')
  })

  $('.show-map-factory').on('click', function (event) {
    event.preventDefault()
    $('.popup__map').addClass('show')
  })

  if (popupHome.hasClass('is-display') && !sessionStorage.getItem('isShowedPopup')) {

    popupHome.addClass('show')
  } else {
    bannerAdvertiseMobile.addClass('show')
    bannerAdvertise.addClass('show')
  }

  // Close popup
  if (popupSuccess.hasClass('show')) {
    setTimeout(function () {
      popupSuccess.removeClass('show')
    }, 4000)
  }

  $('.common__popup-close').on('click', function (event) {
    event.preventDefault()

    if (popupRegisterCompanyTour.hasClass('show')) {
      popupRegisterCompanyTour.removeClass('show')
      clearForm(formRegisterCompanyTour)
    }
    if (popupSuccess.hasClass('show')) {
      popupSuccess.removeClass('show')
    }
    if (popupMap.hasClass('show')) {
      popupMap.removeClass('show')
    }
  })

  $('.home__popup-close').on('click', function (event) {
    event.preventDefault()

    if (popupHome.hasClass('show')) {
      bannerAdvertiseMobile.addClass('show')
      bannerAdvertise.addClass('show')
      popupHome.removeClass('show')
      sessionStorage.setItem('isShowedPopup', 'true')
    }
  })

  $('.popup__success .common-btn').on('click', function () {
    popupSuccess.removeClass('show')
  })

  // Focus & Blur placeholder field input

  if (inputField.length > 0) {
    $.each(inputField, function () {
      if ($(this).val() !== '') {
        $(this).siblings('label').hide()
      }
      if (($(this).val() === null) || ($(this).val() === '')) {
        $(this).siblings('label').show()
      }
    })
  }

  inputField.on('focus', function () {
    $(this).siblings('label').hide()
  })

  inputField.on('blur', function () {
    let el = $(this)
    if (el.val().length === 0) {
      $(this).siblings('label').show()
    }
  })

  inputResetForm.on('click', function () {
    formContact.find('label').show()
    $('.file-name').html('')
  })

  /**
   * Reset all field in form & show placeholder
   * @param element
   */
  function clearForm (element) {
    element.get(0).reset()
    element.find('label').show()
    element.find('.notify-errors').remove()
    errorCaptchaElement.removeClass('active')
    errorCaptchaElement.find('span').remove()
  }

  function settingSlide (element) {
    let options = {
      loop: true,
      touchEventsTarget: 'wrapper',
      pagination: {
        el: '.swiper-pagination',
        clickable: true
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev'
      }
    }
    if (element.find('iframe').length > 0) {
      options.init = false
      options.autoplay = {
        delay: 6000,
        disableOnInteraction: false
      }
    }

    if (element.hasClass('slide-top')) {
      options.autoHeight = true
      options.autoplay = {
        delay: 6000,
        disableOnInteraction: false
      }
    }
    if (element.hasClass('slide-carousel')) {
      options.slidesPerView = 1
      options.autoHeight = true
      options.centeredSlides = true
      options.autoplay = {
        delay: 4000,
        disableOnInteraction: false
      }
      options.breakpoints = {
        768: {
          slidesPerView: 3,
          spaceBetween: 32
        }
      }
    }
    if (element.hasClass('slide-footer')) {
      options.loop = false
      options.slidesPerView = 2
      options.slidesPerColumn = 2
      options.slidesPerColumnFill = 'row'
      options.speed = 1500
      options.spaceBetween = 20
      options.autoplay = {
        delay: 3000,
        disableOnInteraction: false
      }
      options.breakpoints = {
        768: {
          slidesPerView: 4,
          slidesPerColumn: 1,
          spaceBetween: 32,
          pagination: {
            hideOnClick: 'true'
          }
        }
      }
    }
    if (element.hasClass('slide-single')) {
      options = {}
    }
    return options
  }

  // POST commands to YouTube or Vimeo API
  function postMessageToPlayer (player, command) {
    if (player == null || command == null) return
    player.contentWindow.postMessage(JSON.stringify(command), '*')
  }

  // When the slide is changing
  function playPauseVideo (slideInit, slideCurrent, control) {
    let player
    if (slideCurrent.hasClass('youtube')) {
      player = slideCurrent.find('iframe').get(0)
      switch (control) {
        case 'play':
          slideInit.autoplay.stop()
          postMessageToPlayer(player, {
            'event': 'command',
            'func': 'playVideo'
          })
          break
        case 'pause':
          slideInit.autoplay.start()
          postMessageToPlayer(player, {
            'event': 'command',
            'func': 'pauseVideo'
          })
          break
      }
    }
  }

  // Resize player
  function resizePlayer (iframes, ratio) {
    if (!iframes[0]) return
    let win = $('.slide'),
      width = win.width(),
      playerWidth,
      height = win.height()
    ratio = ratio || 16 / 9

    iframes.each(function () {
      let current = $(this)
      playerWidth = Math.ceil(height * ratio)
      current.height(810).css({
        left: 0,
        top: 0
      })
      if ($(window).innerWidth() < 1200) {
        current.height(650)
      }
      if ($(window).innerWidth() <= 1160) {
        current.height(540)
      }
      if ($(window).innerWidth() <= 900) {
        current.height(480)
      }
      if ($(window).innerWidth() < 768) {
        current.height(320)
      }
    })
  }

  // Slider home
  const slideTopInit = new Swiper('.slide-top.swiper-container', settingSlide(slideTop))

  // Slide single
  const slideSingle = new Swiper('.swiper-single')

  // Slide product
  const slideProduct = new Swiper('.slide-carousel.swiper-container', settingSlide($('.slide-carousel')))

  // Slider footer related
  const slideFooter = new Swiper('.slide-footer .swiper-container', settingSlide($('.slide-footer')))

  // Handle event has iframe video
  if (slideTop.length > 0 && (slideTop.find('iframe').length > 0)) {
    slideTopInit.on('init', function (element) {
      let slideCurrent = $(element.slides[element.activeIndex])

      let iframes = slideTop.find('iframe')
      setTimeout(function () {
        playPauseVideo(element, slideCurrent, 'play')

      }, 1000)
      resizePlayer(iframes, 16 / 9)
    })

    slideTopInit.on('slideChangeTransitionStart', function (element) {
      let slideCurrent = $(element.slides[element.previousIndex])
      playPauseVideo(element, slideCurrent, 'pause')

    })
    slideTopInit.on('slideChangeTransitionEnd', function (element) {
      let slideCurrent = $(element.slides[element.activeIndex])
      playPauseVideo(element, slideCurrent, 'play')
    })

    slideTopInit.init()

    // Resize event
    $(window).on('resize orientationchange', function () {
      resizePlayer(iframe, 16 / 9)
      slideTopInit.init()
    })
  }

  /**
   * Check a file upload limit 5 MB
   * @param files
   * @returns {boolean}
   */
  function checkFileSize (files) {
    let check = true
    $.each(files, function (i, file) {
      if (file.size > MAX_FILE_SIZE) {
        check = false
        return false
      }
    })
    return check
  }

  /**
   * Handle multiple file upload & render HTML
   * @param files
   * @param sectionIdentifier
   */
  function handleFileUploader (files, sectionIdentifier) {
    let fileIdCounter = 0
    let fileId, fileName, extensionFileName, fileNameLimit

    if (files.length > 0) {
      $.each(files, function (i, file) {
        fileIdCounter++
        fileName = file.name.split('.')[0]
        extensionFileName = file.name.split('.').pop()
        fileId = sectionIdentifier + '-' + fileIdCounter
        fileNameLimit = ''

        if (fileName.length > 30) {
          fileNameLimit = fileName.substring(0, 27) + '...'
        } else {
          fileNameLimit = fileName
        }

        filesUploadData.push({
          id: fileId,
          fileName: fileNameLimit,
          extensionFileName: extensionFileName,
          file: file
        })
      })
    }
  }

  /**
   * Handle remove file upload
   * @param fileID
   * @param element
   */
  function removeFileUpload (fileID, element) {
    for (let i = 0; i < filesUploadData.length; ++i) {
      if (filesUploadData[i].id === fileID) {
        filesUploadData.splice(i, 1)
      }
    }
    element.parent().remove()
    if (filesUploadData.length === 0) {
      formFileUpload.find('.file-list').hide()
    }
  }

  /**
   * Append files into DOM HTML
   * @param files
   */
  function renderFileUploadHTML (files) {
    if (fileNameHTML.length > 0 && files.length > 0) {
      let fileName = `${ files[0].fileName }.${ files[0].extensionFileName }`
      fileNameHTML.html(fileName)
    }
    if (files.length > 0) {
      fileListHTML.show()

      $.each(files, function (i, file) {
        let li = $('<li>')
        let nameFile = `<strong>${ file.fileName }.${ file.extensionFileName }</strong>`
        // let removeLink = `<a class="remove-file" href="javascript:void(0)" data-file-id="${ file.id }"></a>`
        li.append(nameFile)
        fileListHTML.append(li)
      })
    }
  }

  /**
   *  Handle event upload file from form contact, form career job
   *  Handle a file & multiple file
   */
  formFileUpload.find('.file-list').hide()

  formRecruitment.find('#file-upload').on('focus', function () {
    $(this).siblings('label').show()
  })

  inputFileUpload.on('change', function (event) {
    let files = event.target.files
    // let inputFile = $(this).find('input[type="file"]')
    if (checkFileSize(files)) {
      handleFileUploader(files, 'file-upload')
      if (filesUploadData.length > 0) {
        fileListHTML.empty()
        renderFileUploadHTML(filesUploadData)
      }
      if (formContact.length > 0) {
          if (inputFileUpload.val() !== '') {
            $('label[for="file-upload"]').hide()
          }
      }
    } else {
      files.length = null
      filesUploadData.length = 0
      $(this).find('.file-name').empty()
      fileListHTML.empty()
      fileListHTML.hide()
      fileNameHTML.html('')
      alert('File too Big, please select a file less than 5MB')
      inputFileUpload.val('')
      if (formContact.length > 0) {
        formContact.find('.form-file-upload label').show()
        inputFileUpload.on('focus', function () {
          if (inputFileUpload.val() === '') {
            $(this).siblings('label').show()
          } else {
            $(this).siblings('label').hide()
          }
        })
      }
    }
  })
  /**
   *  Handle event click remove file career job
   */
  formFileUpload.on('click', '.remove-file', function (e) {
    let fileId = $(this).attr('data-file-id')
    removeFileUpload(fileId, $(this))
  })

  inputResetForm.on('click', function () {
    $('#form-contact')[0].reset()
    formContact.find('label').show()
    fileNameHTML.html('')
    filesUploadData.length = 0
  })

  // Handle event booking calendar company tour
  /**
   * Call ajax get data event company tour
   * @param locationID
   * @returns {any}
   */
  function callAjaxEvent (locationID) {
    return JSON.parse(
      $.ajax({
        url: APP_URL +
          `/api/user/company-tours?filters[location]=${ locationID }&include=location&locale=${ languageHTML }`,
        contentType: 'application/json',
        dataType: 'json',
        success: function () {
        },
        async: false,
        error: function (err) {
          console.log(err)
        }
      }).responseText)
  }

  function htmlDecode (input) {
    let e = document.createElement('textarea')
    e.innerHTML = input
    // handle case of empty input
    return e.childNodes.length === 0 ? '' : e.childNodes[0].nodeValue
  }

  /**
   * Call ajax get content & render HTML company visit
   * @param locationID
   * @param language
   * @returns {any}
   */
  function renderHTMLDataCompanyVisit (locationID, language) {
    let content, name, addressFactory, facebookURL, replaceHMTL
    let domainMapGoogle = 'https://maps.google.com/maps'
    let paramsGoogleMap, iframeGoogleMap
    nameFactory.text('')
    linkFacebook.hide()
    linkMapLocationFactory.empty()
    contentRegisterCompanyTour.empty()

    if (locationID.length > 0 && language.length > 0) {
      $.ajax({
        url: APP_URL + `/api/user/company-visit-content/${ locationID }?locale=${ language }`,
        type: 'GET',
        contentType: 'application/json',
        success: function (res) {
          if (res.hasOwnProperty('data')) {
            content = (res.data.content !== null) ? res.data.content : ''
            replaceHMTL = content.replace(/<(|\/*.)pre(( class="ql-syntax" spellcheck="false")*)>/g, '')
            name = res.data.name
            addressFactory = res.data.address
            facebookURL = res.data.facebook_url

            contentRegisterCompanyTour.append(htmlDecode(replaceHMTL))
            paramsGoogleMap = `?width=100%25&amp;height=600&amp;hl=en&amp;q=${ encodeURI(
              addressFactory) }+()&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed`
            iframeGoogleMap = `<iframe
                            width="100%"
                            height="600"
                            frameborder="0"
                            scrolling="no"
                            marginheight="0"
                            marginwidth="0"
                            src="${ domainMapGoogle + paramsGoogleMap }">
                        </iframe>`
            if (languageHTML === 'vi') {
              nameFactory.text('Bản đồ ' + name)
            } else {
              nameFactory.text(name + ' Map')
            }
            linkFacebook.show()
            linkFacebook.attr('href', facebookURL)
            linkMapLocationFactory.append(iframeGoogleMap)
          }
        },
        error: function (err) {
          console.log(err)
        }
      })
    }
  }

  /**
   * Map data event into calendar
   * @param info
   * @param successCallback
   * @param failureCallback
   */
  function handleDataEvents (info, successCallback, failureCallback) {
    if (dataCompanyTour.data.length > 0) {
      successCallback(dataCompanyTour.data.map(function (item) {
        return {
          id: item.id,
          name: item.name,
          start: item.date,
          location: item.location,
          date_event: item.date,
          day_of_week: item.day_of_week,
          cancel: item.is_cancel,
          published: item.is_published,
          people_amount: item.people_amount,
          registry_amount: item.registry_amount,
          type: item.type
        }
      }))
    }
  }

  /**
   * Handle event show on calendar
   * @param info
   */
  function showDataEvents (info) {
    let typeEvents = info.event._def.extendedProps.type,
      cancel = info.event._def.extendedProps.cancel

    info.el.closest('.fc-daygrid-day-events').classList.add('fc-custom-day-events')

    if (typeEvents === 'morning') {
      info.el.closest('.fc-daygrid-event-harness').classList.add('morning')

    } else if (typeEvents === 'special-morning') {
      info.el.closest('.fc-daygrid-event-harness').classList.add('special-morning')

    } else if (typeEvents === 'afternoon') {
      info.el.closest('.fc-daygrid-event-harness').classList.add('afternoon')

    } else {
      info.el.closest('.fc-daygrid-event-harness').classList.add('special-afternoon')
    }
  }

  /**
   * Handle event fill data into popup register company tour
   * @param info
   */
  function handleEventClick (info) {
    let name = info.event._def.extendedProps.name,
      dayOfWeek = info.event._def.extendedProps.day_of_week,
      dayEvent = info.event._def.extendedProps.date_event.split('-').reverse().join('/'),
      location = info.event._def.extendedProps.location.display_name,
      registryAmount = info.event._def.extendedProps.registry_amount,
      peopleAmount = info.event._def.extendedProps.people_amount,
      numberPhone = info.event._def.extendedProps.location.phone,
      email = info.event._def.extendedProps.location.email

    dataUserRegisterCompanyTour.company_tour_id = info.event._def.publicId

    popupRegisterCompanyTour.find('.time-events').html(`${ name }.<br/>${ dayOfWeek }, ${ dayEvent }. `)
    popupRegisterCompanyTour.find('.location').html(`${ location }.`)
    if (popupRegisterCompanyTour.find('.register-amount span').length <= 0) {
      popupRegisterCompanyTour.find('.register-amount').append(
        `&nbsp;<span>${ registryAmount }&nbsp;/${ peopleAmount }</span>`)
    }
    popupRegisterCompanyTour.find('.company-tour__phone span').text(numberPhone)
    popupRegisterCompanyTour.find('.company-tour__email span').text(email)
    popupRegisterCompanyTour.addClass('show')

    clearForm(formRegisterCompanyTour)
    $('#selectLocationVisitors').prop('selectedIndex', 0)
    $('#selectMajors').prop('selectedIndex', 0)
  }

// Setting package fullCalendar
  let OPTION_EVENT = {
    selectable: false,
    locale: languageHTML,
    timeZone: 'UTC',
    height: 'auto',
    autocomplete: 'off',
    eventClick: handleEventClick,
    headerToolbar: {
      start: 'title',
      center: '',
      end: 'prev,next'
    },
    views: {
      dayGridMonth: {
        titleFormat: { year: 'numeric', month: formatMonthFullCalendar }
      }
    },
    timeFormat: 'h:mma',
    displayEventEnd: true,
    slotDuration: {
      'hours': 12
    },
    editable: true,
    eventLimit: true,
    events: handleDataEvents,
    eventDidMount: showDataEvents
  }

// Call ajax data event calendar company tour  when choose factory
  function initCalendar (locationID) {
    if (locationID.length) {
      dataCompanyTour = callAjaxEvent(locationID)
    }
    if (calendarEl) {
      calendar = new FullCalendar.Calendar(calendarEl, OPTION_EVENT)
      calendar.render()
    }
  }

  if (idFactoryCompanyTour.length > 0) {
    locationCompanySelect.find('option').each(function () {
      if ($(this).val() === idFactoryCompanyTour)
        $(this).prop('selected', true)
    })
    initCalendar(idFactoryCompanyTour)
    renderHTMLDataCompanyVisit(idFactoryCompanyTour, languageHTML)

  } else if (defaultLocationFirstID.length > 0) {
    initCalendar(defaultLocationFirstID.val())
    renderHTMLDataCompanyVisit(defaultLocationFirstID.val(), languageHTML)
  }

  function writesErrors (errors) {
    errorCaptchaElement.find('span').remove()
    formRegisterCompanyTour.find('.notify-errors').remove()

    $.each(errors, function (i, error) {
      if (error.field === 'error_captcha') {
        let errorNotify = `<span class="noty-errors">${ error.message[0] }</span>`
        errorCaptchaElement.addClass('active')
        errorCaptchaElement.append(errorNotify)
      } else {
        let inputName = `input[name='${ error.field }']`
        let fieldHasError = $(inputName).closest('.form-group')
        if (fieldHasError.length > 0) {
          let errorNotify = `<span class="notify-errors">${ error.message[0] }</span>`
          fieldHasError.append(errorNotify)
        }
      }
    })
  }

  locationCompanySelect.on('change', function () {
    let locationID = $(this).val()

    window.location.href = window.location.protocol + '//' + window.location.host + window.location.pathname + '?id=' + locationID
    // Render calendar
    // initCalendar(locationID)
    // renderHTMLDataCompanyVisit(locationID, languageHTML)

  })
  /**
   *   Submit data user registered company tour
   */
  formRegisterCompanyTour.submit(function (e) {
    e.preventDefault()
    $(this).serializeArray().map(function (item) {
      dataUserRegisterCompanyTour[item.name] = item.value
    })
    $.ajax({
      type: 'POST',
      url: APP_URL + `/api/user/visitors?locale=${ languageHTML }`,
      data: dataUserRegisterCompanyTour,
      dataType: 'json',
      success: function () {
        popupRegisterCompanyTour.removeClass('show')
        popupSuccess.addClass('show')
        clearForm(formRegisterCompanyTour)
      },
      error: function (xhr) {
        if (xhr.responseJSON.hasOwnProperty('errors')) {
          let errors = xhr.responseJSON.errors
          if (errors.length > 0) {
            writesErrors(errors)
          }
        }
      }
    })
  })

  // Event scroll to element error of form
  if (errorCaptchaElement.length > 0) {
    $('html,body').animate({ scrollTop: errorCaptchaElement.offset().top - 300 }, '2000')
  }

  window.addEventListener('beforeunload', function (event) {
    event.preventDefault()
    if (formContact.length > 0) {
      formContact[0].reset()
      formContact.find('label').show()
      fileNameHTML.html('')
      filesUploadData.length = 0
    }
  })

  function tableSroll () {
    let maxWidthLayoutStatic = $('.w-848').css('max-width')
    if (maxWidthLayoutStatic.length > 0) {
      hasTable.wrap('<div class="table-wrap" style="overflow-x:scroll">')
      hasTable.css({ 'width': `${ maxWidthLayoutStatic }` })
    }
  }

  if (hasTable.length > 0) {
    tableSroll()
  }
})
