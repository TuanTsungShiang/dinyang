<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InquiryResource\Pages;
use App\Filament\Resources\InquiryResource\RelationManagers;
use App\Models\Inquiry;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InquiryResource extends Resource
{
    protected static ?string $model = Inquiry::class;
    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static ?string $navigationGroup = '客戶管理';
    protected static ?string $navigationLabel = '詢價單';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('客戶資訊')->schema([
                Forms\Components\TextInput::make('company_name')->required()->label('公司名稱'),
                Forms\Components\TextInput::make('contact_name')->required()->label('聯絡人'),
                Forms\Components\TextInput::make('phone')->tel()->required()->label('電話'),
                Forms\Components\TextInput::make('email')->email()->required()->label('Email'),
            ])->columns(2),

            Forms\Components\Section::make('詢價內容')->schema([
                Forms\Components\Select::make('product_id')
                    ->relationship('product', 'name')
                    ->label('相關產品'),
                Forms\Components\TextInput::make('source')->required()->label('來源'),
                Forms\Components\Textarea::make('message')->required()->label('訊息')->rows(4)->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Section::make('處理狀態')->schema([
                Forms\Components\Select::make('status')
                    ->options([
                        'new'         => '新進',
                        'in_progress' => '處理中',
                        'completed'   => '已完成',
                        'archived'    => '已封存',
                    ])
                    ->required()
                    ->default('new')
                    ->label('狀態'),
                Forms\Components\Select::make('handled_by')
                    ->options(fn () => User::where('is_admin', true)->pluck('name', 'id'))
                    ->label('處理人員'),
                Forms\Components\DateTimePicker::make('handled_at')->label('處理時間'),
                Forms\Components\Textarea::make('notes')->label('備註')->rows(3)->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Section::make('法遵資訊')->schema([
                Forms\Components\TextInput::make('ip_address')->label('IP 位址')->disabled(),
                Forms\Components\TextInput::make('user_agent')->label('User Agent')->disabled(),
                Forms\Components\DateTimePicker::make('privacy_agreed_at')->label('隱私同意時間')->disabled(),
            ])->columns(2)->collapsible()->collapsed(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company_name')->label('公司')->searchable(),
                Tables\Columns\TextColumn::make('contact_name')->label('聯絡人')->searchable(),
                Tables\Columns\TextColumn::make('phone')->label('電話')->searchable(),
                Tables\Columns\TextColumn::make('email')->label('Email')->searchable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('product.name')->label('產品')->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('狀態')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'new'         => 'info',
                        'in_progress' => 'warning',
                        'completed'   => 'success',
                        'archived'    => 'gray',
                        default       => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'new'         => '新進',
                        'in_progress' => '處理中',
                        'completed'   => '已完成',
                        'archived'    => '已封存',
                        default       => $state,
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('收到時間')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('handled_at')
                    ->label('處理時間')
                    ->dateTime('Y-m-d')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'new'         => '新進',
                        'in_progress' => '處理中',
                        'completed'   => '已完成',
                        'archived'    => '已封存',
                    ])
                    ->label('狀態'),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\AttachmentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListInquiries::route('/'),
            'create' => Pages\CreateInquiry::route('/create'),
            'edit'   => Pages\EditInquiry::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class]);
    }
}
