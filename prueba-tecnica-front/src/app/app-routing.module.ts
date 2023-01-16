
import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { CreateComponent } from './user/create/create.component';
import { EditComponent } from './user/edit/edit.component';
import { IndexComponent } from './user/index/index.component';

const routes: Routes = [
  { path: '', redirectTo: 'user/index', pathMatch: 'full'},
  { path: 'user/index', component: IndexComponent },
  { path: 'user/create', component: CreateComponent },
  { path: 'user/edit/:user.id', component: EditComponent }
]

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
