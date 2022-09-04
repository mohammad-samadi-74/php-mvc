<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220629073804 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $users = $schema->createTable('permission_user');

        $users->addColumn('permission_id', 'integer',['unsigned'=>true]);
        $users->addForeignKeyConstraint('permissions',["permission_id"],['id'],["onDelete" => "CASCADE"]);
        $users->addColumn('user_id', 'integer',['unsigned'=>true]);
        $users->addForeignKeyConstraint('users',["user_id"],['id'],["onDelete" => "CASCADE"]);

        $users->setPrimaryKey(['permission_id','user_id']);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
