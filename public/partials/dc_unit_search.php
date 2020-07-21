<?php

$qry_params = '';
if (count($_GET)) {
  $url = "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
  $parts = parse_url($url);
  parse_str($parts['query'], $qry_params);
  // var_dump( $query );
}
$dc_public = new DoranCafe_Public('DORANCAFE_PLUGIN', '1.0.0-alpha');
?>


 <div class="dc_form-container">
	<h2 class="dc_page_title">FLOOR PLANS</h2>
	<div class="dc_image-search-wrapper" id="dc_image-search-box">
		<div class="dc_page_subtitle">
			<h4>Choose your residence by level</p>
		</div>

		<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1000 325" id="aria-floor-hovers">
			<title>Birke Hover Map</title>
			<g id="birke-front" data-name="birke-front">
   			<image width="1000" height="325" xlink:href="/wp-content/plugins/DoranCafe/public/dist/images/birke-front.jpg"/>
			
				<g id="floor2" class="floor even" data-display-name="Floor 2" data-modal="floorplate2">
					<polygon points="777.63 275 824.63 272 824.63 276 852.63 281 951.63 271 951.63 232 853.63 236 824.63 233 693.63 238 652.63 239 600.63 241 557.63 243 502.63 244 408.63 248 385.63 249 266.4 254.32 229.13 276.5 219.13 281.5 212.13 283.5 190.13 292.5 190.13 297.5 175.13 303.5 161.13 304.5 161.13 308.5 125.13 325.5 200.13 325.5 211.13 322.5 220.13 321.5 232.13 312.5 386.13 300.5 504.13 293.5 504.23 286.25 557.13 285.5 688.13 280.5 777.63 275"/>
					<image class="floor-text" width="390" height="130" transform="matrix(0.24, -0.01, 0, 0.24, 730.73, 253.65)" xlink:href="data:image/png;base64,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"/>
				</g>
				<g id="floor3" class="floor odd" data-display-name="Floor 3" data-modal="floorplate3">
					<polygon points="825.19 232.15 853.19 236.15 951.19 231.15 951.19 186.15 853.19 190.15 824.19 187.15 693.19 192.15 652.19 193.15 600.19 195.15 557.19 197.15 502.19 198.15 408.19 202.15 385.19 203.15 266.13 205.5 230.13 207.5 218.13 209.5 210.13 210.5 190.13 212.5 190.13 218.5 174.13 220.5 149.13 221.5 74.13 235.5 74.13 238.5 41.13 243.5 1.13 242.5 0.13 324.5 125.13 325.5 161.13 308.5 161.13 304.5 175.13 303.5 190.13 297.5 190.13 292.5 212.13 284.5 267.13 254.5 386.13 249.5 502.13 243.5 558.13 242.5 825.19 232.15"/>
					<image class="floor-text" width="390" height="130" transform="matrix(0.24, -0.01, 0, 0.24, 730.78, 211.71)" xlink:href="data:image/png;base64,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"/>
				</g>
				<g id="floor4" class="floor even" data-display-name="Floor 4" data-modal="floorplate4">
					<polygon points="825.06 186.1 853.06 189.1 950.06 186.1 950.06 152.1 853.06 151.1 824.06 152.1 692.06 151.1 652.06 150.1 602.06 149.1 557.06 148.1 502.06 147.1 408.06 146.1 386.06 146.1 305.74 145.37 232 142.45 219.13 140.5 210.44 140 190 135.45 175.13 132.5 148.13 132.5 74 123.45 41.13 119.5 1.13 118.5 0 241.45 41 242.45 74.13 238.5 74.13 235.5 149.13 221.5 174.13 220.5 190.13 218.5 190.13 212.5 230.13 207.5 284.13 205.5 385.65 203.1 557 196.45 825.06 186.1"/>
					<image class="floor-text" width="390" height="131" transform="matrix(0.24, -0.01, 0, 0.24, 731.63, 165.22)" xlink:href="data:image/png;base64,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"/>
				</g>
				<g id="floor5" class="floor odd" data-display-name="Floor 5" data-modal="floorplate5">
					<polygon points="824.76 151.95 852.76 150.95 949.76 151.95 949.76 113.95 852.76 109.95 823.76 113.95 691.76 107.95 651.76 106.95 601.76 104.95 556.13 101.5 501.76 97.95 410.13 94.5 385.13 93.5 305.13 90.5 229.13 87.5 228.87 77.65 218.13 73.5 209.82 73.35 190.5 65.17 190.13 59.5 190.13 53.3 174.82 48.35 148.82 48.35 73.97 18.85 73.7 15.3 40.82 1.35 0.82 1.35 1.13 118.5 41.13 119.5 74.13 123.5 149.13 132.5 175.13 132.5 211.13 140.5 218.82 140.35 231.82 142.35 283.82 144.35 385.35 145.95 556.7 148.3 824.76 151.95"/>
					<image class="floor-text" width="390" height="131" transform="translate(731.04 126.76) scale(0.24)" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAYYAAACDCAYAAACJOrziAAAACXBIWXMAAC4jAAAuIwF4pT92AAANY0lEQVR4Xu3d7XHbxhqG4Sdn8v8wFQSpIEwFhisIU0GoCmJVYKkCKRWIrsB0BYIrMFOBkArCU4HOjyWGAkPiXQC7wAK8rxmOZOmVLIKLfXYXH/zu9fVVAABU/mMVAACuC8EAAKghGAAANQQDAKCGYAAA1BAMAIAaggEAUEMwAABqCAYAQA3BAACo+d4quEILSUurqIPy8ACApBEM/7aU9GwVdXAv6c4qAoCxsZQEAKghGAAANQQDAKCGYAAA1PgGw52k1wk/cgFAf7ns/ibFx7Na8A0GAECcU9mTQzAAgL+FVTAHBAMAoIZgAAB//7UK5oBgAAB/HGMAAFwfggEAUEMwAIA/lpIAADWcrgoAuD4EAwD4uYrZgkQwAICvqzi+IBEMAIATBAMAoIZgAAA/LCUBAGqu5uDz91ZBZIVVEMjeKrgimdybjWSS3h2+lp8vrSkPj52kvw4fdw31U5XLjQx/PHxcyG+kWBw+ftVx25SXiq9IJmkl19aWh3+fs5PbTz9J2lyowUDGDob3VgGCWEn69fCx66gn0zFUKntJW0lfDh+nKNOx41o1lzbKTz5KrrMr5Dq7sUL0TtJHq6jBXtIPVtEZuaQ/5L9N34bv5lLRyELfWfVRbt8ZQqvB8djBgHgyuQ6hTxhYFpLWh8debof+U9MYKa8k/S7/jquL5eHxQW6b3MsFaKuddGQLuW3kG/yZpCf5zUKn5m14hfBFw62atMIxhvnJ5HbMF7kOO1YonFrIdYAvcv9/1lg9npXc3/hZcUPhVKbj63LXWJmeX62Cgw+SvqlfKJRWAeIjGOZjIelBx0AY01qug7hrLhtUJveG6J81bmgt5GZyL+rXgQ7JCtCF3HZ9UP+ByN9WwYyUVsFYCIZ5WMp1xB+swgFVHeA3hZ+CtxViJBtaJhdUITrT2KrlpEvfe274/pyEbselVTAWgmH61nKdXtZcNpqlxu04npR25/tBbvtkRt3Yzi0nVaEQssMsrIIRpdqGgiMYpm0t1/GlrlpqWBt1IS3kAnNt1KWgmvGF7GBDOxfsn5X235yynVUwJoJhutaaRii89aRhOuoYI9nYUv+bT5eTHhRnaW5vFYwk9Gwh1ecpiWCYqrWmFwqVIcLhSel2sE1SD4dqOSlXvONZqY6kQ78mSQcD1zFMz1LTDYXKk9yBt6K5rJMHjXc8I4SF3PZ5r/Q6j5WkG7ltjH7+Ovn3Qnb4lBrogDXBMC3VWv0cfJb0k8J2frnijWSHVIX/b1bhwBaSXq2iHlKdLcTwTsfrffLGyn8r5LbVV/lfeNgKS0nT8qD0z17xVY2MQwn9+8a20rRnPl2EHCSEZo3m28rlllTzxqrzcrkB0GdJ/yjCBaUEw3Tkir82P7SVuu0Y53xQ4J0jAU8Kf9AT3aT6Oizk+oUXBQwIgmE6PloFExVilJ9pnttnoXksjfn6ahWg0VqBbrky9jGG3Croaae0p6e+csXfVmPJ5Br0prGq2RxDofJRbtuUzWWILPSdVWP6KHcG2W/q2G7GDoZnq6Cn94pz5svQhuj4tnJ3eyzffG0hd5BsrbhT6arz66KaSse013H7vB1oZDpun5j+kHRrFc1AaRWMKPQxhtiWchdNvleHg/pjBwNsmeLOFnZypyBeajxbudtFf1S8ZY1M7W7t/NbaKuhpI9cpX5p5buS2T8yrgNdy/8ccZr9NSqsArSzkBt+tw4FjDOlbWQU97OTXaPZyneONUdfH71bBBV1/zsdG7jlbHXIp6RfFm50uFLcdYL6qcGg1aCEY0her49vLrUFand5bG3Ub1ftYqf1yVaaWDb6FQu2DsO32bMP3PRGmzBqgjClWOxvCQm5G671/sZSUtkzxGmTXd1q7VbzR60rtjjXE+jskt3TT1l5uu8Y4JlQFZ6zgCW2v43tf/6+h7p2OV/2m/Ny8O9VEZWpx0STBkLbcKujh0Sq4oJSbNcTolN+pXTC8swo6KtR9WehR7mBxjI4kV7wZWygbufe4LprLMIKVPI/lsZSUtp+tgo626jc6i/UG5rlVcCK3Cjr6ZBU02CtepxgrCEMo5G5xcqN4z38sMUJ+LF73uSIY0hZrGanvhUTmiKOjTP5XbmaKt8MWVoEhleAcykbuJIayuWyyYu2HY8jkcSYfwZC23CroaGcVGKr14xgyq+Agswo6KtW/g4u1bVLsoLZqf5Ae4zKPgREM6cqsgh4Kq8BDaRV0lFsFB7E6ydIq8BArGKR4z7uLva4jFPbqt/SamkzGMUKCIV2ZVdBRaRV4Or2ffCi+tx6ItYzUd5mtEiscYj3vLv7UvDrMS3Zyx0/mdJFh42nwnJV0fUqrwFOsHcR3RBzrwHwoMbdPYRUN5NEqmJG93M3pHuXuANDmzLOdLreHTPEGgU0aZwwEQ7pyq2BksUbEvnx3yrZCPa/SKugo1vNuq6mzmzMrIHZywf1Vrg34tqdc7iLGlYYLilwXBhkEw/XxbahjGbvjC9XZ/W0VTFxhFczc24BY63ijxa7tpzg8buV+34Pi7wu5LryOHGO4Pk1XoaZgaRUgCXMPPl97uXDYqHsonNrIHdOIPYi7eF0MwQCgi9id1rXby+8Gl31kl75BMABAmvaKezpwdukbYx9juLcKeiqtAgBI2E5uaWndXNbZQmeWwMYOhjurAMH5XicwltIqAK7MF8ULhqXOHIBmKSldoQ5knUr94G5pFUQW6kyQH60CwFNhFYRGMKQr5kGnEMYOmNIq6CjU88qsAsBTrEHiRQTD9cmsAk+hRtanfHeCaz1dsrAKgL4IhnTFmjFkVoGnWLek8L0Hk2+AtBXqPQ9yqwBIFcGQrr3idX65VeAhswo6Kq2Cg5SDM7MKeiisAsxOqOXNc8pzXyQY0har8+vb0Bbq/zsuKa2Cg1jbJlP/jj23CjoqrQLMUqx9TSIYJilW59d3uSS3CnoorIKDveJ1lLlVYOi7fS+J1R6QtsZbZMdAMKQt1HsDnFqp38HjX62Cjtp2fIVV0FHfHXFlFXTke/wF4XyWu94qay6LJlf/gcolxaVvEAxpK6yCHj5YBRcsFO9im8IqOBErOHN17wjW6he6TbZWAYJbyL0V5otcSMQK/XMyuf8zlvLSNwiGtO0VrzNo80Yjb3UNFB9frIITsbaN5G573IX5frod7dV+RoWwVnId9T+SntR/5t1kKemb4v1+qWEGSjCkr21n6Wsh17jbyBW34yusohMxg3Ol9jOjB3WfaVhiPU+0V82aq5B4lltuyi/+hL+F3O+KHQoSS0mTtlW801ZXcuHg0wBzxZ3WbqyCC2IFp+S2je8M6UH+tV18sgowmlxuwPQs6VWuU3/SMSyWF36uslQ9aGINvt4q1TADJRjSF3NULLkG+U2uU8vOfL8Kj2f5BUhXf1oFF2wU7+wkyXX4zzp/7KAaOb4obiiUaj+bwniqjr4Ki29ygfGq4wzj5c3XqiBZnfldsTT2KQTDNMS+PXkm1wFWjfWbXAN+lRvFrC/9YCCF+nXusUfTudyOW22TamRYrTVnl34wkNivP4azUL+TG0Jp3GcIhmko1X2ppYul4s4OTvXt+B4Vb7ntnNwqCKjUsK895q+QcSIDwTAd9xq28xtKof7LJHu5N1Gfo76hCZwy2xTBMB2lPF7Qidkr3FsXbtQ/YFJTiNkCwirksZ8QDNPyKI8XdULu1e/YwqkbzWtWNddZEMbj1aYIhun5TfPo/Aq5oAuplGfDn4BbcUEbwrqXZ5siGKZnL+m9VZS4nVzAxbBR+MAZ2kbTfw5Iy1buugovBMM07RRubX5o1XGFmLOeW013bX6r6b62SFPr/oJgmK6NWr7YCahmO17T2Z5uNL1wKDS91xRp28ntc60GYgTDtG3U4UUfSdVAhwiFyo2msySz0XReS0xDoY5timCYvkLDd7htbTXe33ir9A/Y34qZAsK6V8dQkAiGudhJ+kXpXeewVxod81Zu+xRG3dCq120qsxqkr5qZ3xl1jQiGeblTOh3gRtJPSqfTK+V2mBuFvXaiiyowf9E4syj4m8qxqlLubw2y/xMM81ONGN4rQANpaa9jIMQ+86irjY5/X9lYGV4pFwgpBSaalXJt5YfDx9SCvDqL7ScFDLDvrQJMVnF4ZHJ3R/1d8e7ouJV7X4St0gyDczaHRy63bVaKc+PAverbB9NUDXo2cvtRLumdxrlT6lbubW23ijS4+e719dWqkdyTz42aLu6sghFkinOb6ULDj+BPZTo26OrztsrD46vSeE4hLeUC4ufD51lj9Xk71bfP2CPMXN1eZ8tGkTqlCcrk2stSru0sFOYOxXsd29Nfh8+LhvpgfIMB81U14srbBl28+XrVSK/N6Q6eHz6ebo9SdJT4t9P969zXipPvlxq5LREMAIAaDj4DAGoIBgBADcEAAKghGAAANQQDAKCGYAAA1BAMAIAaggEAUEMwAABqCAYAQA3BAACoIRgAADUEAwCghmAAANQQDACAGoIBAFBDMAAAaggGAEANwQAAqCEYAAA1BAMAoIZgAADUEAwAgBqCAQBQQzAAAGoIBgBADcEAAKghGAAANQQDAKCGYAAA1BAMAICa/wNmN7uDEtKTOAAAAABJRU5ErkJggg=="/>
				</g>
				<g id="floor6" class="floor even" data-display-name="Floor 6" data-modal="floorplate6">
					<polygon points="828.23 113.53 828.23 44.53 774.32 39.41 744.88 48.05 745.13 60.2 692.23 55.53 680.13 58.5 654.13 56.5 654.1 52.64 602.13 48.5 592.13 53.5 558.84 50.8 559.13 45.5 409.59 35.09 410.13 30.5 384.55 28.6 382.59 32.09 307.13 27.5 307.13 23.5 234.13 16.5 231.13 14.5 231.13 2.5 229.13 0.5 41.13 0.5 73.13 14.5 73.13 19.5 148.13 47.5 175.13 47.5 190.13 52.5 190.13 65.5 211.13 73.5 218.13 73.5 229.13 77.5 229.13 87.5 285.13 88.5 557.13 101.5 653.13 107.5 692.13 107.5 776.14 110.99 828.23 113.53"/>
					<image class="floor-text" width="390" height="130" transform="matrix(0.24, 0.01, 0, 0.24, 731.04, 84)" xlink:href="data:image/png;base64,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"/>
				</g>
			</g>
		</svg>
	<!-- modal -->
	<div id="dc_upload_modal" class="dc_modal" style="display: none;">
		<div class="dc_modal-content">
			<div class="dc_modal-title">
				<span class="dc_modal_close">&times;</span>
				<h3></h3>
				<span>Click on a unit to view details</span></div>
			<div class="dc_modal-form-wrapper">
			</div>
		</div>
	</div>

	<form action="" class="dc_search-form" id="dc_search_form">
		<div class="dc_form-wrapper-header">
			<div class="dc_left-col narrow">
				<p style="font-family: 'Josefin Sans';font-size: 1.4em;letter-spacing: -.01em;">SEARCH by Filter</p>
			</div>
			<div class="dc_left-col">
				<?php /*
				<div class="dc_form-row">
					<label for="availability">Availability</label>
					<div class="dc_form-element">
						<select name="availability" id="availability">
							<option value="all" selected="selected">All</option>
							<option value="available">Available only</option>
							<option value="unavailable">Unavailable only</option>
						</select>
					</div>
				</div>
				*/;?>
				<div class="dc_form-row">
					<!-- <label for="beds">Bedrooms</label> -->
					<div class="dc_form-element">
						<select name="beds" id="beds" required>
						<option value="" selected disabled>Bedrooms</option>
							<option value="alcove">Alcove</option>
							<option value="1">1 BR</option>
							<option value="2">2 BR</option>
							<option value="3">3 BR</option>
							<option value="Townhome">2 BR Townhome</option>
						</select>
					</div>
				</div>

				<div class="dc_form-row">
					<!-- <label for="floorplanname">Floorplan Name</label> -->
					<div class="dc_form-element">
						<select name="floorplanname" id="floorplanname" required>
						<option value="" selected disabled>Floor Plan</option><?php
							$floorplans = $dc_public->dc_public_get_floorplans();
							foreach ($floorplans as $floorplan): ?>
								<option value="<?php echo $floorplan->FloorplanName; ?>"><?php echo $floorplan->FloorplanName; ?></option><?php
							endforeach; ?>
						</select>
					</div>
				</div>

				<?php /*
				<div class="dc_form-row">
				<label for="price">Price</label>
				<div class="dc_form-element">
				<select name="price" id="price">
				<option value="" selected="selected">-select-</option>
				<option value="1400_1750">$1,400-$1,650</option>
				<option value="1651_2150">$1,651-$2,150</option>
				<option value="2001_2500">$2,151-$2,500</option>
				<option value="2501_3000">$2,501-$3,000</option>
				<option value="3000_10000">3000+</option>
				</select>
				</div>
				</div>
				*/;?>
			</div>

			<div class="dc_middle-col">
				<div class="dc_form-row">
					<!-- <label for="baths">Bathrooms</label> -->
					<div class="dc_form-element">
						<select name="baths" id="baths" required>
							<option value="" selected disabled>Baths</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="2.5">2.5</option>
						</select>
					</div>
				</div>
				<div class="dc_form-row">
					<!-- <label for="unit_view">View</label> -->
					<div class="dc_form-element">
						<select name="unit_view" id="unit_view" required>
							<option value="" selected disabled>Unit View</option>
							<option value="North">North</option>
							<option value="East">East</option>
							<option value="South">South</option>
							<option value="West">West</option>
						</select>
					</div>
				</div>
				<div class="dc_form-row">
					<!-- <label for="floor">Floor</label> -->
					<div class="dc_form-element">
						<select name="floor" id="floor" required>
							<!-- <option value="" selected="selected">-select-</option> -->
							<option value="" selected disabled>Floor</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
						</select>
					</div>
				</div>
			</div>

			<div class="dc_right-col">
				<h4>Additional Features</h4>
				<div class="dc_form-row dc_form-check">
					<div class="dc_form-element">
						<input type="checkbox" name="feature4" id="feature4" value="terrace">
					</div>
					<label for="feature4">Terrace</label>
				</div>
				<div class="dc_form-row dc_form-check">
					<div class="dc_form-element">
						<input type="checkbox" name="feature1" id="feature1" value="balcony">
					</div>
					<label for="feature1">Balcony</label>
				</div>
				<div class="dc_form-row dc_form-check">
					<div class="dc_form-element">
						<input type="checkbox" name="feature2" id="feature2" value="fireplace">
					</div>
					<label for="feature2">Fireplace</label>
				</div>
				<div class="dc_form-row dc_form-check">
					<div class="dc_form-element">
						<input type="checkbox" name="feature5" id="feature5" value="appliance">
					</div>
					<label for="feature5">Premium Appliance Package</label>
				</div>
				<!--
				<div class="dc_form-row dc_form-check">
					<div class="dc_form-element">
						<input type="checkbox" name="feature3" value="Patio">
					</div>
					<label for="features3">Patio</label>
				</div> -->
			</div>
		</div>

		<div class="dc_clear-filter">
			<a href="" class="dc_btn" id="clear_filter">Clear Filters</a>
		</div>
		<?php /*
		<div class="dc_restricted" style="">
<p>To be added to the waiting list for our 10 income-restricted units, please email <a href="mailto:leasing@ariaedina.com">leasing@ariaedina.com</a>.</p>
 
<p>Inquiring about our 10 income-restricted units? <a href="/income-restricted/">Click here.</a></p>
</div>
 */;?>
		<div class="dc_form-footer">
			<div class="dc_left-col">
				<div class="display-count-wrapper">
					<label for="display_count">Display</label>
					<select name="display_count" id="display_count">
						<option value="12" selected="selected">12</option>
						<option value="24">24</option>
						<option value="36">36</option>
					</select>
				</div>
			</div>

			<div class="dc_right-col">
				<div class="sort-wrapper">
					<label for="sort_by">Sort By</label>
					<select name="sort_by" id="sort_by">
						<option value="" selected="selected">-select-</option>
						<?php /*
<option value="price_high">Price (highest)</option>
<option value="price_low">Price (lowest)</option>
 */;?>
						<option value="size_high">Size (largest)</option>
						<option value="size_low">Size (smallest)</option>
					</select>
				</div>
			</div>
		</div>
		<div class="dc_search-results"><?php

$dc_public->dc_public_get_units($qry_params);?>
		</div>
	</form>
</div>
