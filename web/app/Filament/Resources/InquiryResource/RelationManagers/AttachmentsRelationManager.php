<?php

namespace App\Filament\Resources\InquiryResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class AttachmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'attachments';
    protected static ?string $title = '附件';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\FileUpload::make('path')
                ->required()
                ->label('檔案')
                ->directory('inquiry-attachments')
                ->storeFileNamesIn('original_name'),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('original_name')->label('檔案名稱')->searchable(),
                Tables\Columns\TextColumn::make('mime_type')->label('類型'),
                Tables\Columns\TextColumn::make('size_bytes')
                    ->label('大小')
                    ->formatStateUsing(fn ($state) => $state ? number_format($state / 1024, 1) . ' KB' : '-'),
                Tables\Columns\TextColumn::make('created_at')->label('上傳時間')->dateTime('Y-m-d H:i'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
