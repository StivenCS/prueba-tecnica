import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
/*
import { IndexComponent } from './index/index.component';
import { CreateComponent } from './create/create.component';
import { EditComponent } from './edit/edit.component'; */

const routes: Routes = [];
/* const routes: Routes = [
  { path: 'user', redirectTo: 'user/index', pathMatch: 'full'},
  { path: 'user/index', component: IndexComponent },
  { path: 'user/create', component: CreateComponent },
  { path: 'user/edit/:user.id', component: EditComponent }
] */

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class UserRoutingModule { }
