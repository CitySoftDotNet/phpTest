function BusinessReviewManager() {
    var self = this;

    self.dataFeedUrl = 'data.php';
    self.businessName = ko.observable();
    self.businessAddress = ko.observable();
    self.businessPhone = ko.observable();
    self.totalAvgRating = ko.observable();
    self.totalNumberOfReviews = ko.observable();
    self.externalUrl = ko.observable();
    self.externalPageUrl = ko.observable();
	
    self.customerReviews = ko.observableArray([]);
	
	self.initialize();
}

BusinessReviewManager.prototype.initialize = function () {
    var self = this;

    // initialize the business information
    self.getBusinessInformation();
};

BusinessReviewManager.prototype.getBusinessInformation = function () {
    var self = this;

    $.ajax({
        url: self.dataFeedUrl,
        async: false,
        type: 'GET',
        dataType: 'json',
    	beforeSend: function (r) {
        },
        success: function (r) {
            self.updateBusinessInformation(r);
        },
        complete: function (r) {
        },
        error: function (a, b, c) {
            // handle web service error here
        }
    });
};

BusinessReviewManager.prototype.updateBusinessInformation = function (result) {
    var self = this;

    self.businessName(result.business_info.business_name);
    self.businessAddress(result.business_info.business_address);
    self.businessPhone(result.business_info.business_phone);
    self.totalAvgRating(result.business_info.total_rating.total_avg_rating);
    self.totalNumberOfReviews(result.business_info.total_rating.total_no_of_reviews);
    self.externalUrl(result.business_info.external_url);
    self.externalPageUrl(result.business_info.external_page_url);

	self.customerReviews(result.reviews);
	
	//alert(self.customerReviews);
};

$(document).ready(function() {
	ko.applyBindings(new BusinessReviewManager());
});