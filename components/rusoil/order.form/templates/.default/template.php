<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
use Bitrix\Main\Page\Asset;
use \Bitrix\Main\Localization\Loc;
CJSCore::Init(array("jquery"));
Asset::getInstance()->addCss("/bitrix/css/main/bootstrap_v4/bootstrap.min.css");

?>
<div class="container">
	<form id="order-form">
		<h6 class="mb-2"><?=Loc::getMessage('new_order')?></h6>
		<div class="mt-3">
			<div class="row">
				<div class="col-3">
					<label class="form-check-label">
						<?=Loc::getMessage('title')?>
					</label>
					<input class="form-control form-control-sm has-error" type="text" name="title" required>
					<div class="invalid-feedback">
						<?=Loc::getMessage('error')?>
					</div>
				</div>
			</div>
		</div>
		<div class="mt-3">
		<h6><?=Loc::getMessage('category')?></h6>
			<div class="form-check">
				<input class="form-check-input" type="radio" name="category" value="1" checked>
				<label class="form-check-label">
					Масла, автохимия, фильтры. Автоаксессуары, обогреватели, запчасти, сопутствующие товары
				</label>
			</div>
			<div class="form-check">
				<input class="form-check-input" type="radio" name="category" value="2">
				<label class="form-check-label">
					Шины, диски
				</label>
			</div>
		</div>
		<div class="mt-3">
			<h6 class="mb-2"><?=Loc::getMessage('order_type')?></h6>
			<div class="form-check">
				<input class="form-check-input" type="radio" name="order_type" value="1" checked>
				<label class="form-check-label">
					Запрос цены и сроков поставки
				</label>
			</div>
			<div class="form-check">
				<input class="form-check-input" type="radio" name="order_type" value="2">
				<label class="form-check-label">
					Пополнение складов
				</label>
			</div>
			<div class="form-check">
				<input class="form-check-input" type="radio" name="order_type" value="3">
				<label class="form-check-label">
					Спецзаказ
				</label>
			</div>
		</div>
		<div class="mt-3">
			<h6 class="mb-2"><?=Loc::getMessage('storage')?></h6>
			<div class="row">
				<div class="col-3">
					<select class="form-control form-control-sm" name="storage">
						<option selected disabled><?=Loc::getMessage('choose_storage')?></option>
						<option value="1">1 склад</option>
						<option value="2">2 склад</option>
					</select>
				</div>
			</div>
		</div>
		<div class="mt-3">
			<h6 class="mb-2"><?=Loc::getMessage('options')?></h6>
			<div class="form-row flex-nowrap mt-3 mb-0">
				<div class="col-2 text-center my-auto">
					<p class="m-auto text-danger"><?=Loc::getMessage('brand')?></p>
				</div>
				<div class="col-2 text-center">
					<p class="m-auto text-danger"><?=Loc::getMessage('name')?></p>
				</div>
				<div class="col-2 text-center">
					<p class="m-auto text-danger"><?=Loc::getMessage('quantity')?></p>
				</div>
				<div class="col-2 text-center">
					<p class="m-auto text-danger"><?=Loc::getMessage('packing')?></p>
				</div>
				<div class="col-2 text-center">
					<p class="m-auto text-danger"><?=Loc::getMessage('client')?></p>
				</div>
			</div>
		</div>
		<div id="rows">
			<div class="form-row flex-nowrap mt-1" data-example="yes" hidden>
				<div class="col-2">
					<select class="form-control form-control-sm" name="brand[]">
							<option value=""><?=Loc::getMessage('choose_brand')?></option>
							<option value="1">Бренд 1</option>
							<option value="2">Бренд 2</option>
					</select>
				</div>
				<div class="col-2">
					<input type="text" class="form-control form-control-sm" name="name[]">
				</div>
				<div class="col-2">
					<input type="text" class="form-control form-control-sm" name="quantity[]">
				</div>
				<div class="col-2">
					<input type="text" class="form-control form-control-sm" name="packing[]">
				</div>
				<div class="col-2">
					<input type="text" class="form-control form-control-sm" name="client[]">
				</div>
				<div class="col-2">
					<input type="button" class="btn btn-sm btn-primary" value="+">
					<input type="button" class="btn btn-sm btn-primary" value="-">
				</div>
			</div>
		</div>
		<div class="row mt-3">
			<div class="col-3">
				<input type="file" style="padding:0" class="form-control-file form-control-sm" name="file[]" multiple>
			</div>
		</div>
		<div class="mt-3">
			<p class="mb-1"><?=Loc::getMessage('comment')?></p>
			<div class="row">
				<div class="col-6">
					<textarea class="form-control" name="comment"></textarea>
				</div>
			</div>
		</div>
		<button class="btn btn-secondary btn-sm mt-3" type="button"><?=Loc::getMessage('send')?></button>
	</form>
	<div class="answer"></div>
</div>
