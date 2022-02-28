$(document).ready(function () {
  // Pagination element HTML
  const paginationWrap = $('.product__content .common-pagination')
  const paginationList = $('.page-list')

  // Get data category is active
  const categoryList = $('.common__category')
  const urlCateIsActive = categoryList.find('.active').data('url')

  // Product list element
  const productList = $('#product-list')

  const loading = `<div id="loading" class="text-center">
                        <img style="width: 50px; height:auto" src="/assets/img/loading.gif" alt="image loading">
                    </div>`

  /*
   * Call ajax
   * @param url
   */
  function ajaxFilterCategory (url) {
    const category = categoryList.find('.active')
    const value = category.data('value')
    const postPage = category.data('page')
    const postType = category.data('type')

    $.ajax({
      type: 'GET',
      url: url,
      data: { slug: value, postPage: postPage, postType: postType, perPage: 16 },
      cache: false,
      beforeSend: function () {
        $('#product-content').html(loading)
      },
      success: function (response) {
        $('#product-content').html(response)
        $('#product-content .page-total').hide()
      },
      error: function () {
        $('#product-content').html('')
      }
    })
  }

  // Void main
  ajaxFilterCategory(urlCateIsActive)

  categoryList.on('click', 'a', function () {
    productList.empty()
    paginationWrap.empty()
    paginationList.empty()
    $(this).closest('.common__category').find('.active').removeClass('active')
    $(this).addClass('active')
    ajaxFilterCategory($(this).attr('data-url'))
  })

  $('.product').on('click', '.page-list  a', function () {
    ajaxFilterCategory($(this).attr('href'))
    return false
  })
})
