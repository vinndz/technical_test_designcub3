<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Technical Test</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

</head>

<body>
    <div class="container mt-5">
        <h2 class="text-start mb-4">Select Location - Tugas 1</h2>
        <form>
            <div class="row mb-3">
                <div class="col">
                    <label for="selectProvince" class="form-label">Select Province</label>
                    <select class="form-select" id="selectProvince" required>
                        <option value="" disabled selected>Choose one</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="selectCity" class="form-label">Select City</label>
                    <select class="form-select" id="selectCity" required>
                        <option value="" disabled selected>Choose one</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="selectDistrict" class="form-label">Select District</label>
                    <select class="form-select" id="selectDistrict" required>
                        <option value="" disabled selected>Choose one</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="selectSubdistrict" class="form-label">Select Subdistrict</label>
                    <select class="form-select" id="selectSubdistrict" required>
                        <option value="" disabled selected>Choose one</option>
                    </select>
                </div>
            </div>
        </form>
    </div>


    <div class="container mt-4">
        <h2 class="text-start mb-4">Email Subscription - Tugas 2</h2>
        <form action="{{ route('subscription.store') }}" method="POST" class="row g-0" id="subscriptionForm">
            @csrf
            <div class="mb-3>
                <label for=" email" class="form-label">Get the latest insight into property and infrastructure</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="email" placeholder="Email...">
                    <button type="submit" class="btn btn-danger">Subscribe</button>
                </div>
                <div id="responseMessage" class="mt-2"></div>
            </div>
        </form>


    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".form-select").select2({
                minimumResultsForSearch: '100%',
                width: '100%' // Ensure Select2 dropdown is 100% width
            });

            $("#selectProvince").select2({
                ajax: {
                    url: "{{route('province.index')}}",
                    processResults: function({ data }) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id,
                                    text: item.name
                                };
                            })
                        };
                    }
                }
            }).on("change", function() {
                let id = $(this).val();
                $("#selectCity").empty().append('<option value="" disabled selected>Select City...</option>').trigger('change');
                $("#selectCity").select2({
                    ajax: {
                        url: "{{url('getCity')}}/" + id,
                        processResults: function({ data }) {
                            return {
                                results: $.map(data, function(item) {
                                    return {
                                        id: item.id,
                                        text: item.name
                                    };
                                })
                            };
                        }
                    }
                });
            });

            $("#selectCity").on("change", function() {
                let id = $(this).val();
                $("#selectDistrict").empty().append('<option value="" disabled selected>Select District...</option>').trigger('change');
                $("#selectDistrict").select2({
                    ajax: {
                        url: "{{url('getDistrict')}}/" + id,
                        processResults: function({ data }) {
                            return {
                                results: $.map(data, function(item) {
                                    return {
                                        id: item.id,
                                        text: item.name
                                    };
                                })
                            };
                        }
                    }
                });
            });

            $("#selectDistrict").on("change", function() {
                let id = $(this).val();
                $("#selectSubdistrict").empty().append('<option value="" disabled selected>Select Subdistrict...</option>').trigger('change');
                $("#selectSubdistrict").select2({
                    ajax: {
                        url: "{{url('getSubdistrict')}}/" + id,
                        processResults: function({ data }) {
                            return {
                                results: $.map(data, function(item) {
                                    return {
                                        id: item.id,
                                        text: item.name
                                    };
                                })
                            };
                        }
                    }
                });
            });

            $("#subscriptionForm").on('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission

                const emailInput = $('#email');
                const responseMessage = $('#responseMessage');

                // Clear previous messages
                responseMessage.html('');

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: {
                        email: emailInput.val(),
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        if (data.status === 'success') {
                            responseMessage.html('<ul class="list-unstyled"><li class="text-success">' + data.message + '</li></ul>');
                            emailInput.val(''); // Clear the input
                        }
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON.messages;
                        const errorList = errors.map(error => '<li class="text-danger">• ' + error + '</li>').join('');
                        responseMessage.html('<ul class="list-unstyled">' + errorList + '</ul>');
                    }
                });
            });
        });
    </script>
</body>

</html>