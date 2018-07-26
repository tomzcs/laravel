home = {
  start: function() {
    $('#users-table').DataTable({
      processing: true,
      serverSide: true,
      pageLength: 10,
      ajax: {
        "url": 'http://192.168.88.15/user_data',
        "type": "POST",
        headers: {
          'X-CSRF-TOKEN': $('input[name=_token]').val()
        }
      },
      columns: [{
          data: 'id',
          name: 'id'
        },
        {
          data: 'name',
          name: 'name'
        },
        {
          data: 'email',
          name: 'email'
        },
        {
          data: function(res) {
            var string = '';
            for (a of res.role) {
              switch (a) {
                case 'manager':
                  string += '<h5><span class="badge badge-danger">' + a + '</span></h5>';
                  break;
                case 'mobile':
                  string += '<h5><span class="badge badge-success">' + a + '</span></h5>';
                  break;
                default:
                  string += '<h5><span class="badge badge-primary">' + a + '</span></h5>';
              }
            }
            return string;
          }
        },
        {
          data: function(res) {
            return `<a href="` + base_url + '/edit_form/' + res.id + `">
                     <svg id="i-edit" viewBox="0 0 32 32" width="32" height="32" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                         <path d="M30 7 L25 2 5 22 3 29 10 27 Z M21 6 L26 11 Z M5 22 L10 27 Z" />
                     </svg>
                   </a>`
          }
        },
      ]
    });
  }
}
