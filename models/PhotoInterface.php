<?php
namespace SNiPI\UniqueMediaFinder\Models;

interface PhotoInterface {
	
	public function getAuthor(): array;
	public function getId(): string;
	public function getData(): array;
	public function getLinks(): array;
	public function getDownloadLink(): string;
	public function getPreviewLink(): string;

}