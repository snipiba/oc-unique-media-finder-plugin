<?php
namespace SNiPI\UniqueMediaFinder\Classes;

interface FinderInterface {

	public function search(string $query, array $options, int $page = 1):array;
	public function getPhoto(string $photoIdentifier): array;
	public function downloadPhoto(string $photoIdentifier): bool;
	public function configured(): bool;
	
}